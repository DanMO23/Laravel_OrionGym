<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pacote;
use App\Models\AlunoPacote;
use App\Models\Aluno;
use App\Models\AlunoAvaliacao;


class AvaliacaoController extends Controller
{
    public function create(Request $request)
{
    // Verifica se o ID do aluno foi passado na requisição
    $aluno = null;

    if ($request->has('aluno_id')) {
        // Busca o aluno pelo ID
        $aluno = Aluno::find($request->input('aluno_id'));
    }

    // Retorna a view 'create' com os dados do aluno, se existir
    return view('avaliacao.create', compact('aluno'));
}
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'nome' => 'required|string|max:255',
        'cpf' => 'required|string|max:14',
        'data_avaliacao' => 'required|date',
        'horario_avaliacao' => 'required',
        'descricao_pagamento' => 'nullable|string|max:255',
        'telefone' => 'required|string|max:15',
        'valor_avaliacao' => 'nullable|numeric|min:0',
    ]);

    $valorAvaliacao = $request->has('alterar_valor') ? $request->valor_avaliacao : 50.00;

    AlunoAvaliacao::create([
        'nome' => $validatedData['nome'],
        'cpf' => $validatedData['cpf'],
        'data_avaliacao' => $validatedData['data_avaliacao'],
        'horario_avaliacao' => $validatedData['horario_avaliacao'],
        'descricao_pagamento' => $validatedData['descricao_pagamento'],
        'telefone' => $validatedData['telefone'],
        'valor_avaliacao' => $valorAvaliacao,
    ]);

    return redirect()->route('avaliacao.index')->with('success', 'Avaliação criada com sucesso!');
}

    public function index()
    {
        // Busca todas as avaliações
        $avaliacoes = AlunoAvaliacao::all();

        //retorte a data de avaliacao no formato brasileiro
        foreach ($avaliacoes as $avaliacao) {
            $avaliacao->data_avaliacao = date('d/m/Y', strtotime($avaliacao->data_avaliacao));
        }
        //retorna a view em ordem crescente, de acordo com a data, mes e 
        $avaliacoes = $avaliacoes->sortBy('data_avaliacao');

        return view('avaliacao.index', compact('avaliacoes'));
    }

    public function confirmarAvaliacao($id)
    {
        $avaliacao = AlunoAvaliacao::find($id);
        if ($avaliacao) {
            $avaliacao->status = 'Finalizada';
            $avaliacao->save();
            return redirect()->route('avaliacao.index')->with('success', 'Avaliação finalizada com sucesso.');
        }
        return redirect()->route('avaliacao.index')->with('error', 'Avaliação não encontrada.');
    }

    public function cancelarAvaliacao($id)
    {
        $avaliacao = AlunoAvaliacao::find($id);
        if ($avaliacao) {
            $avaliacao->delete();
            return redirect()->route('avaliacao.index')->with('success', 'Avaliação cancelada e excluída com sucesso.');
        }
        return redirect()->route('avaliacao.index')->with('error', 'Avaliação não encontrada.');
    }
}
