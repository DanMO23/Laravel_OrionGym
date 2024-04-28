<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pacote;

class PacoteController extends Controller
{
    public function index()
    {
        $pacotes = Pacote::all();
        return view('pacotes.index', compact('pacotes'));
    }

    public function create()
    {
        return view('pacotes.create');
    }

    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'validade' => 'required|integer|min:1',
        ]);

        // Criação de um novo pacote com base nos dados do formulário
        $pacote = new Pacote([
            'nome_pacote' => $request->nome,
            'valor' => $request->valor,
            'validade' => $request->validade,
        ]);

        // Salva o pacote no banco de dados
        $pacote->save();

        // Redireciona de volta à página de listagem de pacotes com uma mensagem de sucesso
        return redirect()->route('pacotes.index')->with('success', 'Pacote criado com sucesso!');
    }

    public function show(Pacote $pacote)
    {
        return view('pacotes.show', compact('pacote'));
    }

    public function edit(Pacote $pacote)
    {
        return view('pacotes.edit', compact('pacote'));
    }

    public function update(Request $request, Pacote $pacote)
    {
        // Validação dos dados do formulário
        $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'validade' => 'required|integer|min:1',
        ]);

        // Atualiza os dados do pacote com base nos dados do formulário
        $pacote->update([
            'nome_pacote' => $request->nome,
            'valor' => $request->valor,
            'validade' => $request->validade,
        ]);

        // Redireciona de volta à página de listagem de pacotes com uma mensagem de sucesso
        return redirect()->route('pacotes.index')->with('success', 'Pacote atualizado com sucesso!');
    }

    public function destroy(Pacote $pacote)
    {
        $pacote->delete();
        return redirect()->route('pacotes.index');
    }
}
