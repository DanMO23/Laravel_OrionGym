<?php


namespace App\Http\Controllers;

use App\Events\NovaCompra;
use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Pacote;
use App\Models\AlunoPacote;
use App\Events\CompraAtualizada;
use App\Events\CompraExcluida;

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
        
        $alunoPacote->update([
            'pacote_id' => $request->input('pacote'),
            'descricao_pagamento' => $request->input('descricao_pagamento')
        ]);
        
        event(new CompraAtualizada($alunoPacote, $pacoteAntigoId));

        return redirect()->route('compra.historico')->with('success', 'AlunoPacote atualizado com sucesso.');
    }

    public function destroy($id)
    {
        // Recuperar a compra a ser excluída
        $compra = AlunoPacote::findOrFail($id);
        
        // Disparar o evento de exclusão da compra
        event(new CompraExcluida($compra));
        
        // Excluir a compra
        $compra->delete();
        return redirect()->route('compra.historico')->with('success', 'AlunoPacote deletado com sucesso.');
    }
    
}
