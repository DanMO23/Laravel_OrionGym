<?php

namespace App\Http\Controllers;

use App\Models\TurnstileCommand;
use App\Models\TurnstileEvent;
use Illuminate\Http\Request;

class TurnstileWebController extends Controller
{
    public function index()
    {
        $turnstileCommands = TurnstileCommand::latest()->limit(50)->get();
        $turnstileEvents = TurnstileEvent::latest()->limit(50)->get();

        return view('turnstile.index', compact('turnstileCommands', 'turnstileEvents'));
    }

    public function openTurnstile()
    {
        TurnstileCommand::create([
            'type' => 'remote_open',
            'data' => json_encode(['reason' => 'Manual open via Dashboard', 'requested_by' => auth()->user()->name ?? 'Admin']),
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Comando de liberação enviado com sucesso!');
    }
}
