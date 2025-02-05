<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function create()
    {
        return view('produto.create');
    }

    public function store(Request $request)
    {
        // Valida os dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantidade_estoque' => 'required|integer|min:0',
            'valor' => 'required|numeric|min:0',
        ]);

        // Cria o produto
        $produto = new Produto();
        $produto->nome = $request->nome;
        $produto->descricao = $request->descricao;
        $produto->estoque = $request->quantidade_estoque;
        $produto->valor = $request->valor;

        // Upload da foto, se fornecida
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/produtos'), $fileName);
            $produto->foto = $fileName;
        }

        $produto->save();

        return redirect()->route('produto.index')->with('success', 'Produto criado com sucesso.');
    }

    public function index()
    {
        $produtos = Produto::all();
        return view('produto.index', compact('produtos'));
    }

    public function edit(Produto $produto)
    {
        return view('produto.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        // Valida os dados
        $request->validate([
            'quantidade_estoque' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'valor' => 'required|numeric|min:0',
        ]);

        // Atualiza os dados do produto
        $produto->estoque = $request->quantidade_estoque;
        $produto->valor = $request->valor;

        // Verifica se há uma nova foto para upload
        if ($request->hasFile('foto')) {
            // Remove a foto antiga, se existir
            if ($produto->foto && file_exists(public_path('uploads/produtos/' . $produto->foto))) {
                unlink(public_path('uploads/produtos/' . $produto->foto));
            }

            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/produtos'), $fileName);
            $produto->foto = $fileName;
        }

        $produto->save();

        return redirect()->route('produto.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Produto $produto)
    {
        // Remove a foto se ela existir
        if ($produto->foto && file_exists(public_path('uploads/produtos/' . $produto->foto))) {
            unlink(public_path('uploads/produtos/' . $produto->foto));
        }

        // Deleta o produto
        $produto->delete();

        return redirect()->route('produto.index')->with('success', 'Produto deletado com sucesso.');
    }
}
