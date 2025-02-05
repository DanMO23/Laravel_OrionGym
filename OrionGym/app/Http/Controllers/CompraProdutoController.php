<?php

namespace App\Http\Controllers;

use App\Models\CompraProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompraProdutoController extends Controller
{
    /**
     * Exibe o formulário para criar uma nova compra para um produto específico.
     *
     * @param int $produto_id
     * @return \Illuminate\View\View
     */
    public function create($produto_id)
    {
        // Buscar o produto pelo ID
        $produto = Produto::findOrFail($produto_id);

        // Passar o produto para a view
        return view('compraProduto.create', compact('produto'));
    }

    /**
     * Armazena uma nova compra no banco de dados.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Log::info('Iniciando o processo de armazenamento de compra.');

        // Valida os dados da requisição
        try {
            $validated = $request->validate([
                'produto_id' => 'required|exists:produtos,id',
                'nome_comprador' => 'required|string|max:255',
                'quantidade' => 'required|integer|min:1',
                'valor_produto' => 'nullable|numeric|min:0|required_if:alterar_valor,1',
            ]);
            Log::info('Dados validados com sucesso.', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro na validação dos dados.', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // Busca o produto
        $produto = Produto::find($validated['produto_id']);
        Log::info('Produto encontrado.', ['produto' => $produto]);

        // Verifica se o valor foi alterado pelo usuário
        if ($request->has('alterar_valor') && $request->alterar_valor) {
            $valorFinal = $validated['valor_produto'];
            Log::info('Valor do produto alterado pelo usuário.', ['valor_final' => $valorFinal]);
        } else {
            // Se não foi alterado, usa o valor original do produto
            $valorFinal = $produto->valor;
            Log::info('Usando valor original do produto.', ['valor_final' => $valorFinal]);
        }

        Log::info('Criando compra...', [
            'produto_id' => $produto->id,
            'comprador' => $validated['nome_comprador'],
            'quantidade' => $validated['quantidade'],
            'valor_total' => $valorFinal * $validated['quantidade']
        ]);

        // Decrementa do estoque
        $produto->estoque -= $validated['quantidade'];
        $produto->save();
        Log::info('Estoque do produto atualizado.', ['estoque' => $produto->estoque]);
        
        // Cria o registro da compra
        CompraProduto::create([
            'produto_id' => $produto->id,
            'comprador' => $validated['nome_comprador'],
            'valor_produto' => $valorFinal,
            'quantidade' => $validated['quantidade'],
            'valor_total' => $valorFinal * $validated['quantidade'], // Valor final multiplicado pela quantidade
        ]);
        Log::info('Registro da compra criado com sucesso.');

        // Redireciona com sucesso
        return redirect()->route('compraProduto.historico')->with('success', 'Compra realizada com sucesso!');
    }


    /**
     * Exibe o histórico de compras.
     *
     * @return \Illuminate\View\View
     */
    public function historico()
    {
        // Recupera todas as compras ordenadas por data de criação decrescente
        $compras = CompraProduto::with('produto')->orderBy('created_at', 'desc')->get();

        return view('compraProduto.historico', compact('compras'));
    }

    /**
     * Exibe a view de edição de uma compra específica.
     *
     * @param \App\Models\CompraProduto $compra
     * @return \Illuminate\View\View
     */
    public function edit(CompraProduto $compra)
    {
        return view('compraProduto.edit', compact('compra'));
    }

    /**
     * Atualiza uma compra específica no banco de dados.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CompraProduto $compra
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, CompraProduto $compra)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1',
        ]);

        $produto = $compra->produto;
        $novaQuantidade = $request->quantidade;

        // Calcula a diferença na quantidade
        $diferenca = $novaQuantidade - $compra->quantidade;

        // Verifica se há estoque suficiente para a atualização
        if ($diferenca > 0 && $produto->estoque < $diferenca) {
            return redirect()->back()->withErrors(['quantidade' => 'Estoque insuficiente para a atualização.'])->withInput();
        }

        // Atualiza o valor total
        $compra->valor_total = $produto->valor * $novaQuantidade;
        $compra->quantidade = $novaQuantidade;
        $compra->save();

        // Atualiza o estoque do produto
        $produto->estoque -= $diferenca;
        $produto->save();

        return redirect()->route('compraProduto.historico')->with('success', 'Compra atualizada com sucesso.');
    }

    /**
     * Remove uma compra específica do banco de dados.
     *
     * @param \App\Models\CompraProduto $compra
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Tenta encontrar o produto relacionado à compra, se não encontrar, gera um 404
        
        $compra = CompraProduto::findOrFail($id);
        $produto = Produto::findOrFail($compra->produto_id);
        // Atualiza o estoque do produto com a quantidade da compra que será removida
        $produto->estoque += $compra->quantidade;
        $produto->save();

        // Deleta a compra
        $compra->delete();

        return redirect()->route('compraProduto.historico')->with('success', 'Compra deletada com sucesso.');
    }
}
