<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use Spatie\Permission\Traits\HasRoles;

class FuncionarioController extends Controller
{
    public function index()
    {
        $funcionarios = Funcionario::all();

        return view('funcionarios.index', compact('funcionarios'));
    }

    public function create()
    {
        // Verifica se o usuário tem o papel 'admin'
        if (auth()->user()->hasRole('admin')) {
            return view('funcionarios.create');
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

        $request->validate([
            'nome' => 'required',
            'email' => 'required|email',
            'cargo' => 'required',
        ]);

        $funcionario = new Funcionario();
        $funcionario->nome_completo = $request->nome;
        $funcionario->email = $request->email;
        $funcionario->telefone = $request->telefone;
        $funcionario->cargo = $request->cargo;
        $funcionario->sexo = $request->sexo;
        $funcionario->endereco = $request->endereco;

        // Upload da foto, se fornecida
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $funcionario->foto = $fileName;
        }

        $funcionario->save();

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário criado com sucesso!');
    }

    public function show(Funcionario $funcionario)
    {
        return view('funcionarios.show', compact('funcionario'));
    }

    public function edit(Funcionario $funcionario)
    {
        return view('funcionarios.edit', compact('funcionario'));
    }

    public function update(Request $request, Funcionario $funcionario)
    {
        $funcionario->update($request->all());
        return redirect()->route('funcionarios.index');
    }

    public function destroy(Funcionario $funcionario)
    {
        $funcionario->delete();
        return redirect()->route('funcionarios.index');
    }
}
