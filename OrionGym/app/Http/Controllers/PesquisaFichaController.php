<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FichaTreino;
use App\Models\Treino;

class PesquisaFichaController extends Controller
{
    public function index()
    {
        return view('pesquisaFicha.index');
    }

    public function buscar(Request $request)
    {
        $nome = $request->query('nome');
        $fichas = FichaTreino::where('nome_aluno', 'LIKE', "%$nome%")->get();
        return response()->json($fichas);
    }

    public function mostrar($id)
    {
        $ficha = FichaTreino::findOrFail($id);
        $treinos = Treino::where('ficha_treino_id', $id)->get();
        return view('pesquisaFicha.show', compact('ficha', 'treinos'));
    }

    public function imprimir($id)
    {
        $ficha = FichaTreino::with('treinos.exercicios')->findOrFail($id);
        return view('pesquisaFicha.imprimir', compact('ficha'));
    }
}
