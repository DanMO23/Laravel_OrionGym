<?php

namespace App\Http\Controllers;

use App\Events\NovaCompra;
use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Pacote;
use App\Models\AlunoPacote;
use App\Events\CompraAtualizada;
use App\Events\CompraExcluida;
use App\Models\AlunosVencidos;

class CompraController extends Controller
{
    public function create()
    {
        $alunos = Aluno::orderBy('nome', 'asc')->get();
        $pacotes = Pacote::all();

        return view('compra.create', compact('alunos', 'pacotes'));
    }


    public function store(Request $request)
    {
        // Validar os dados do formulário, se necessário
        $request->validate([
            'aluno' => 'required|exists:alunos,id',
            'pacote' => 'required|exists:pacotes,id',
            'descricao_pagamento' => 'required',
            'valor_pacote' => 'nullable|numeric',
        ]);

        // Criar uma nova compra de pacote
        $compra = new AlunoPacote();
        $compra->aluno_id = $request->aluno;
        $compra->pacote_id = $request->pacote;
        $compra->descricao_pagamento = $request->descricao_pagamento;

        // Verificar se o campo para alterar o valor do pacote foi marcado
        if ($request->has('alterar_valor') && $request->input('alterar_valor') == 'on' && $request->filled('valor_pacote')) {
            // Se sim, usar o valor preenchido pelo usuário
            $compra->valor_pacote = $request->input('valor_pacote');
        } else {
            // Caso contrário, usar o valor padrão do pacote selecionado
            $pacoteSelecionado = Pacote::find($request->pacote);
            if ($pacoteSelecionado) {
                $compra->valor_pacote = $pacoteSelecionado->valor;
            }
        }

        $aluno = Aluno::find($request->aluno);
        if ($aluno) {
            $aluno->matricula_ativa = 'ativa';

            $aluno->save();
        }
        //se o aluno for encontrado em alunos_vencidos, findorfail ele de la
        $alunoVencido = AlunosVencidos::where('aluno_id', $request->aluno)->first();
        if ($alunoVencido) {
            $alunoVencido->delete();
        }
       

        $compra->save();
        event(new NovaCompra($compra));

        // Redirecionar para alguma página após a compra ser feita
        return redirect()->route('compra.historico')->with('success', 'Compra de pacote realizada com sucesso!');
    }

    public function index()
    {
        $compras = AlunoPacote::orderBy('created_at', 'desc')->get();
        
        return view('compra.historico', compact('compras'));
    }

    public function historico()
    {
        $compras = AlunoPacote::orderBy('created_at', 'desc')->get(); // Recupera todas as compras do banco de dados
        return view('compras.historico', compact('compras'));
    }

    public function edit($id)
    {
        $compra = AlunoPacote::with('aluno')->findOrFail($id);
        $pacotes = Pacote::all(); // Carregar todos os pacotes
        return view('compra.edit', compact('compra', 'pacotes'));
    }
    public function update(Request $request, $id)
{
    $alunoPacote = AlunoPacote::findOrFail($id);
    $pacoteAntigoId = $alunoPacote->pacote_id;

    // Verificar se o campo para editar o valor do pacote foi marcado
    if ($request->has('editar_valor')){
        // Se sim, usar o valor preenchido pelo usuário
        $alunoPacote->valor_pacote = $request->input('valor_pacote');
    } else {
        // Caso contrário, verificar se foi selecionado um novo pacote
        if ($request->has('pacote')) {
            $pacoteSelecionado = Pacote::find($request->input('pacote'));
            if ($pacoteSelecionado) {
                $alunoPacote->valor_pacote = $pacoteSelecionado->valor;
            }
        }
    }

    // Atualizar outros campos se necessário
    $alunoPacote->pacote_id = $request->input('pacote');
    
    $alunoPacote->descricao_pagamento = $request->input('descricao_pagamento');
    $alunoPacote->save();

    event(new CompraAtualizada($alunoPacote, $pacoteAntigoId));

    return redirect()->route('compra.historico')->with('success', 'AlunoPacote atualizado com sucesso.');
}




    public function destroy($id)
    {
        // Recuperar a compra a ser excluída
        $compra = AlunoPacote::findOrFail($id);
        $aluno = Aluno::find($compra->aluno_id);
        
        // Disparar o evento de exclusão da compra
        event(new CompraExcluida($compra));
        
        // Excluir a compra
        $compra->delete();
       

        return redirect()->route('compra.historico')->with('success', 'Compra deletado com sucesso.');
    }
}
