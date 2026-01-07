<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Models\TurmaAluno;
use App\Models\Professor;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index()
    {
        // No need to load professor relationship anymore
        $turmas = Turma::with('alunos')->get();
        return view('turmas.index', compact('turmas'));
    }

    public function create()
    {
        return view('turmas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'dia_semana' => 'required|string',
            'horario' => 'required',
            'nome_professor' => 'required|string|max:255',
        ]);

        Turma::create($request->all());

        return redirect()->route('turmas.index')->with('success', 'Turma criada com sucesso!');
    }

    public function show($id)
    {
        $turma = Turma::with(['alunos'])->findOrFail($id);
        return view('turmas.show', compact('turma'));
    }

    public function edit($id)
    {
        $turma = Turma::findOrFail($id);
        return view('turmas.edit', compact('turma'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'dia_semana' => 'required|string',
            'horario' => 'required',
            'nome_professor' => 'required|string|max:255',
        ]);

        $turma = Turma::findOrFail($id);
        $turma->update($request->all());

        return redirect()->route('turmas.index')->with('success', 'Turma atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $turma = Turma::findOrFail($id);
        $turma->delete();

        return redirect()->route('turmas.index')->with('success', 'Turma removida com sucesso!');
    }

    // Methods for adding/removing students

    public function addAluno(Request $request, $id)
    {
        $request->validate([
            'nome_aluno' => 'required|string|max:255',
        ]);

        $turma = Turma::findOrFail($id);
        
        TurmaAluno::create([
            'turma_id' => $turma->id,
            'nome_aluno' => $request->nome_aluno,
        ]);

        return back()->with('success', 'Aluno adicionado à turma!');
    }

    public function removeAluno($id)
    {
        $aluno = TurmaAluno::findOrFail($id);
        $aluno->delete();

        return back()->with('success', 'Aluno removido da turma!');
    }
}
