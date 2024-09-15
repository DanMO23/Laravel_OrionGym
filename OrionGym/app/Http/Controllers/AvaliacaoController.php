<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pacote;
use App\Models\AlunoPacote;
use App\Models\Aluno;

class AvaliacaoController extends Controller
{
    
    public function index()
    {
        return view('avaliacao.index');
    }
    
    public function create()
    {
        $pacotes = Pacote::all();
        return view('avaliacao.create', compact('pacotes'));
    }
    
    public function store(Request $request)
{
    // Validar os dados do formulário
    $request->validate([
        'nome' => 'required|string|max:255',
        'cpf' => 'required|string|max:14', // Pode-se usar regex para CPF, se desejar
        'descricao_pagamento' => 'required|string|max:255',
    ]);

    // Criar uma nova entrada para a Avaliação Física
    $avaliacao = new AlunoPacote(); // Supondo que a tabela seja a mesma de pacotes comprados
    $avaliacao->aluno_id = 9999; // Aluno fixo
    
    // Definindo os valores conforme solicitado


    $avaliacao->nome = $request->nome; // Nome do aluno fixo
    $avaliacao->pacote_id = $request->pacote; // Nome do pacote fixo
   
    $avaliacao->descricao_pagamento = $request->descricao_pagamento; // Descrição do pagamento fornecida

    // Campos adicionais para nome e CPF
    

    $avaliacao->cpf = $request->cpf;

    // Salvar a avaliação
    $avaliacao->save();

    // Redirecionar para alguma página após o sucesso
    return redirect()->route('compra.historico')->with('success', 'Avaliação Física registrada com sucesso!');
}

    
    public function show($avaliacao)
    {
        return view('avaliacao.show', compact('avaliacao'));
    }
    
    public function edit($avaliacao)
    {
        return view('avaliacao.edit', compact('avaliacao'));
    }
    
    public function update(Request $request, $avaliacao)
    {
        return redirect()->route('avaliacao.index');
    }
    
    public function destroy($avaliacao)
    {
        return redirect()->route('avaliacao.index');
    }
    
    public function search(Request $request)
    {
        return view('avaliacao.index');
    }
}
