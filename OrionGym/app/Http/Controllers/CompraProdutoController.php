<?php

namespace App\Http\Controllers;

use App\Models\CompraProduto;
use App\Models\Produto;
use Illuminate\Http\Request;

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
    // Valida os dados da requisição
    $validated = $request->validate([
        'produto_id' => 'required|exists:produtos,id',
        'nome_comprador' => 'required|string|max:255',
        'quantidade' => 'required|integer|min:1',
        'valor_produto' => 'required|numeric|min:0',
    ]);

    // Busca o produto
    $produto = Produto::find($validated['produto_id']);

    // Verifica se o valor foi alterado pelo usuário
    if ($request->has('alterar_valor') && $request->alterar_valor) {
        $valorFinal = $validated['valor_produto'];
    } else {
        // Se não foi alterado, usa o valor original do produto
        $valorFinal = $produto->valor;
    }

    //decrementa do estoque
    $estoque = $produto->estoque;
    $estoque -= $validated['quantidade'];
    $produto->estoque = $estoque;
    $produto->save();
    
    // Cria o registro da compra
    CompraProduto::create([
        'produto_id' => $produto->id,
        'comprador' => $validated['nome_comprador'],
        'quantidade' => $validated['quantidade'],
        'valor_total' => $valorFinal * $validated['quantidade'], // Valor final multiplicado pela quantidade
    ]);

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
        $produto->quantidade_estoque -= $diferenca;
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
