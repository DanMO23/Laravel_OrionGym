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
        Pacote::create($request->all());
        return redirect()->route('pacotes.index');
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
        $pacote->update($request->all());
        return redirect()->route('pacotes.index');
    }

    public function destroy(Pacote $pacote)
    {
        $pacote->delete();
        return redirect()->route('pacotes.index');
    }
}
