<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aluno;

class AlunoController extends Controller
{
    public function index()
    {

        $search = request('search');

        if ($search) {
            $alunos = Aluno::where([
                ['nome', 'like', '%' . $search . '%']
            ])->get();
        } else {
            $alunos = Aluno::all();
        }

        return view('alunos.index', ['alunos' => $alunos, 'search' => $search]);
    }

    public function create()
    {
        return view('alunos.create');
    }

    public function store(Request $request)
    {
        // Validar os dados do formulário
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:alunos',
            'telefone' => 'required|string|max:20',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|max:14|unique:alunos',
            'sexo' => 'required|in:M,F',
            'endereco' => 'required|string|max:255',
        ]);

        // Criar um novo aluno com os dados fornecidos
        Aluno::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'data_nascimento' => $request->data_nascimento,
            'cpf' => $request->cpf,
            'sexo' => $request->sexo,
            'endereco' => $request->endereco,
            'dias_restantes' => 0,
            'matricula_ativa' => 'inativa',
        ]);

        // Redirecionar de volta para a página de listagem de alunos
        return redirect()->route('alunos.index')->with('success', 'Aluno criado com sucesso!');
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        // Buscar alunos no banco de dados com base no termo de busca
        $alunos = Aluno::where('nome', 'LIKE', "%{$searchTerm}%")
            ->orWhere('email', 'LIKE', "%{$searchTerm}%")
            ->orWhere('telefone', 'LIKE', "%{$searchTerm}%")
            ->orWhere('cpf', 'LIKE', "%{$searchTerm}%")
            ->orWhere('endereco', 'LIKE', "%{$searchTerm}%")
            ->get();

        // Retornar a view com os resultados da busca
        return view('alunos.index', ['alunos' => $alunos, 'searchTerm' => $searchTerm]);
    }
    public function show(Aluno $aluno)
    {
        return view('alunos.show', compact('aluno'));
    }

    public function trancarMatricula(Aluno $aluno)
    {
        $aluno = Aluno::findOrFail($aluno->id);
        $aluno->matricula_ativa = 'trancado';
        $aluno->save();

        return redirect()->route('alunos.index')->with('success', 'Matrícula do aluno trancada com sucesso.');
    }
    

    public function destrancarMatricula($id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->matricula_ativa = 'ativa';
        $aluno->save();

        return redirect()->route('alunos.index')->with('success', 'Matrícula do aluno destrancada com sucesso.');
    }

    public function edit(Aluno $aluno)
    {
        return view('alunos.edit', compact('aluno'));
    }

    public function update(Request $request, Aluno $aluno)
    {
        $aluno->update($request->all());
        return redirect()->route('alunos.index');
    }

    public function destroy(Aluno $aluno)
    {
        $aluno->delete();
        return redirect()->route('alunos.index');
    }
}
