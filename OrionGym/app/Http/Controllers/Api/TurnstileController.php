<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TurnstileCommand;
use App\Models\TurnstileEvent;
use App\Models\User;
use App\Services\GympassService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TurnstileController extends Controller
{
    public function ping()
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
            'version' => '1.0'
        ]);
    }

    public function pendingCommands()
    {
        $commands = TurnstileCommand::where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();
            
        return response()->json($commands);
    }

    public function confirmCommand(Request $request, $id)
    {
        $command = TurnstileCommand::findOrFail($id);
        
        $command->update([
            'status' => $request->success ? 'completed' : 'failed',
            'result_message' => $request->message,
            'completed_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Comando confirmado'
        ]);
    }

    public function handleEvent(Request $request)
    {
        $request->validate([
            'event_type' => 'required|in:entry,exit,denied,error',
            'direction' => 'required|in:entry,exit',
            'timestamp' => 'required|date',
            'success' => 'required|boolean'
        ]);
        
        $event = TurnstileEvent::create($request->all());
        
        // Notificar Gympass se for check-in
        if ($request->success && $request->direction === 'entry' && $request->user_id) {
            $user = User::find($request->user_id);
            if ($user && $user->is_gympass) {
                // GympassService::notifyCheckIn($user); // TODO: Implementar se necessário
                Log::info("Check-in Gympass detectado via catraca para usuário: {$user->name}");
            }
        }
        
        return response()->json([
            'success' => true,
            'event_id' => $event->id
        ]);
    }

    public function pendingSyncUsers()
    {
        $users = User::where('sync_status', 'pending')
            ->orWhere('updated_at', '>', Carbon::now()->subMinutes(5))
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'card_number' => $user->card_number,
                    'password' => $user->turnstile_password,
                    'active' => $user->active,
                    // 'expires_at' => $user->expires_at, // Adicionar se tiver campo de expiração
                    // 'has_biometry' => $user->biometry()->exists(), // Adicionar se tiver relação de biometria
                    // 'biometry_data' => $user->biometry?->data_base64
                ];
            });
        
        return response()->json($users);
    }

    public function confirmUserSync(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $user->update([
            'sync_status' => $request->success ? 'synced' : 'error',
            'last_sync_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Usuário sincronizado'
        ]);
    }
}
