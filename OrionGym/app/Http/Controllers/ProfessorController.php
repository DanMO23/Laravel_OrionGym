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
            return view('professores.create');
        }

        // Redireciona para uma página de erro ou retorna um erro 403 se o usuário não for admin
        abort(403, 'Unauthorized action.');
    }

    public function store(Request $request)
    {
        // Verifica se o usuário tem o papel 'admin'
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Validação dos dados
        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'required|string|max:20',
            'sexo' => 'required|in:M,F',
            'cargo' => 'required|string|max:100',
            'tipo' => 'required|in:integral,personal,ambos',
            'endereco' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Criar um novo registro de professor
        $professor = new Professor();
        $professor->nome_completo = $validated['nome_completo'];
        $professor->email = $validated['email'] ?? null;
        $professor->telefone = $validated['telefone'];
        $professor->cargo = $validated['cargo'];
        $professor->sexo = $validated['sexo'];
        $professor->endereco = $validated['endereco'] ?? null;
        $professor->tipo = $validated['tipo'];

        // Upload da foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $professor->foto = $filename;
        }

        // Gerar matrícula automaticamente se for personal ou ambos
        if (in_array($validated['tipo'], ['personal', 'ambos'])) {
            $professor->numero_matricula = Professor::gerarProximaMatricula();
        }

        // Salvar o novo professor no banco de dados
        $professor->save();

        // Redirecionar para a página desejada após o armazenamento
        return redirect()->route('professores.index')
            ->with('success', 'Professor criado com sucesso! ' . 
                ($professor->numero_matricula ? 'Matrícula: ' . $professor->numero_matricula : ''));
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
