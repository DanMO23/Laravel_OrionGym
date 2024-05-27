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
       // Verifica se o usuário tem o papel 'admin'
       if (auth()->user()->hasRole('admin')) {
        return view('professores.create')->with('funcionarios', Funcionario::all());
    }

    // Redireciona para uma página de erro ou retorna um erro 403 se o usuário não for admin
    abort(403, 'Unauthorized action.');
    }

    public function store(Request $request)
    {
        // Verifica se o usuário tem o papel 'admin'
        if (!auth()->user()->hasRole('admin')) {
            // Redireciona para uma página de erro ou retorna um erro 403 se o usuário não for admin
            abort(403, 'Unauthorized action.');
        }

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
        if (auth()->user()->hasRole('admin')) {
            return view('professores.edit', compact('professor'));
        }

        // Redireciona para uma página de erro ou retorna um erro 403 se o usuário não for admin
        abort(403, 'Unauthorized action.');
    }

    public function update(Request $request, Professor $professor)
    {
        if (!auth()->user()->hasRole('admin')) {
            // Redireciona para uma página de erro ou retorna um erro 403 se o usuário não for admin
            abort(403, 'Unauthorized action.');
        }
        $professor->update($request->all());
        return redirect()->route('professores.index');
    }

    public function destroy(Professor $professor)
    {
        $professor->delete();
        return redirect()->route('professores.index');
    }
}
