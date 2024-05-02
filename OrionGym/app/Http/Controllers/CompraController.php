<?php


namespace App\Http\Controllers;

use App\Events\NovaCompra;
use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Pacote;
use App\Models\AlunoPacote;

class CompraController extends Controller
{
    public function create()
    {
        $alunos = Aluno::all();
        $pacotes = Pacote::all();

        return view('compra.create', compact('alunos', 'pacotes'));
    }


   
    public function store(Request $request)
    {
        // Validar os dados do formulário, se necessário

        // Criar uma nova compra de pacote
        $compra = new AlunoPacote();
        $compra->aluno_id = $request->aluno;
        $compra->pacote_id = $request->pacote;
        $compra->descricao_pagamento = $request->descricao_pagamento;

        
        $aluno = Aluno::find($request->aluno);
        if ($aluno) {
            $aluno->matricula_ativa = 'ativa';
            $aluno->save();
        }
        $compra->save();
        event(new NovaCompra($compra));

        // Redirecionar para alguma página após a compra ser feita
        return redirect()->route('compra.historico')->with('success', 'Compra de pacote realizada com sucesso!');
    }

    public function index()
    {
        $compras = AlunoPacote::all();

        return view('compra.historico', compact('compras'));
    }

    public function historico()
    {
        $compras = AlunoPacote::all(); // Recupera todas as compras do banco de dados
        return view('compras.historico', compact('compras'));
    }
}
