<?php

namespace App\Http\Controllers;

use App\Models\GympassCheckin;
use Illuminate\Http\Request;

class GympassWebController extends Controller
{
    public function index(Request $request)
    {
        $checkins = GympassCheckin::with('user')->latest()->paginate(20);
        
        if ($request->ajax()) {
            return view('gympass.partials.checkin_list', compact('checkins'));
        }

        $gympassUsers = \App\Models\User::where('is_gympass', true)->latest()->get();
        
        return view('gympass.index', compact('checkins', 'gympassUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gympass_id' => 'required|string|unique:users,gympass_id',
        ]);

        // Gerar um email placeholder já que o campo foi removido da UI
        $email = 'gympass_' . $request->gympass_id . '@oriongym.local';

        // Encontrar o maior card_number atual (começando de 12222)
        $maxCard = \App\Models\User::whereRaw('CAST(card_number AS UNSIGNED) >= 12222')
            ->selectRaw('MAX(CAST(card_number AS UNSIGNED)) as max_card')
            ->value('max_card');

        $nextCard = $maxCard ? $maxCard + 1 : 12222;

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => bcrypt('password'), // Senha padrão
            'gympass_id' => $request->gympass_id,
            'is_gympass' => true,
            'card_number' => (string) $nextCard,
            'active' => true,
        ]);

        return redirect()->route('gympass.index')->with('success', 'Usuário Gympass cadastrado com sucesso! Cartão: ' . $nextCard);
    }
}
