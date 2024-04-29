<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professor;
use App\Models\Funcionario;

class ProfessorController extends Controller
{
    public function index()
    {
        $professores = Professor::all();
        return view('professores.index', compact('professores'));
    }

    public function create()
    {
        return view('professores.create')->with('funcionarios', Funcionario::all());
    }

    public function store(Request $request)
    {
        $funcionario = Funcionario::findOrFail($request->input('funcionario_id'));

        // Criar um novo registro de professor
        $professor = new Professor();
        
        // Copiar os dados do funcionário para o novo professor
        $professor->nome_completo = $funcionario->nome_completo;
        $professor->email = $funcionario->email;
        $professor->telefone = $funcionario->telefone;
        $professor->cargo = $funcionario->cargo;
        $professor->sexo = $funcionario->sexo;
        $professor->endereco = $funcionario->endereco;
        $professor->foto = $funcionario->foto;
        $professor->tipo = $request->input('tipo');
        // Adicione outros campos conforme necessário

        // Salvar o novo professor no banco de dados
        $professor->save();

        // Redirecionar para a página desejada após o armazenamento
        return redirect()->route('professores.index')->with('success', 'Professor criado com sucesso.');
    }
    public function show(Professor $professor)
    {
        return view('professores.show', compact('professor'));
    }

    public function edit(Professor $professor)
    {
        return view('professores.edit', compact('professor'));
    }

    public function update(Request $request, Professor $professor)
    {
        $professor->update($request->all());
        return redirect()->route('professores.index');
    }

    public function destroy(Professor $professor)
    {
        $professor->delete();
        return redirect()->route('professores.index');
    }
}
