<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;

class FuncionarioController extends Controller
{
    public function index()
    {
        $funcionarios = Funcionario::all();

        return view('funcionarios.index', compact('funcionarios'));
    }

    public function create()
    {
        return view('funcionarios.create');
    }

    public function store(Request $request)
    {
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
