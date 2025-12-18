<?php

namespace App\Services;

use App\Models\GympassCheckin;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GympassService
{
    /**
     * Processa o webhook de check-in do Gympass.
     */
    public function processCheckinWebhook(array $data)
    {
        // O payload do Gympass geralmente contém o ID do evento e dados do usuário
        // Exemplo hipotético baseado na documentação padrão
        $gympassId = $data['event_id'] ?? $data['id'] ?? null;
        $userGympassId = $data['user']['id'] ?? null;

        if (!$gympassId) {
            Log::error('Gympass Webhook: ID do evento não encontrado', $data);
            return null;
        }

        // Tenta encontrar o usuário pelo ID do Gympass
        $user = User::where('gympass_id', $userGympassId)->first();

        // Verifica se o check-in já existe para evitar duplicação
        $checkin = GympassCheckin::where('gympass_id', $gympassId)->first();

        if ($checkin) {
            Log::info("Gympass Webhook: Evento duplicado recebido ({$gympassId})");
            return $checkin;
        }

        $checkin = GympassCheckin::create([
            'gympass_id' => $gympassId,
            'user_id' => $user ? $user->id : null,
            'status' => 'pending',
            'response_data' => $data,
        ]);

        // Se o usuário existe, podemos tentar validar automaticamente
        if ($user) {
            $validationResult = $this->validateCheckin($user->gympass_id);

            if ($validationResult['success']) {
                $checkin->update([
                    'status' => 'approved',
                    'response_data' => array_merge($checkin->response_data ?? [], ['validation' => $validationResult['data']])
                ]);
                
                // TODO: Integrar com a catraca aqui
                // TurnstileService::allowAccess($user);
            } else {
                $checkin->update([
                    'status' => 'rejected',
                    'response_data' => array_merge($checkin->response_data ?? [], ['validation_error' => $validationResult['error']])
                ]);
            }
        }

        return $checkin;
    }

    /**
     * Valida um check-in manualmente.
     */
    public function validateCheckin($gympassId)
    {
        // Mock para testes locais
        if (str_starts_with($gympassId, 'TEST_')) {
            return ['success' => true, 'data' => ['mock' => true, 'message' => 'Validation bypassed for test ID']];
        }

        $baseUrl = config('gympass.base_url');
        $gymId = config('gympass.gym_id');
        $apiKey = config('gympass.api_key');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'X-Gym-Id' => $gymId,
                'Content-Type' => 'application/json',
            ])->post("{$baseUrl}/access/v1/validate", [
                'gympass_id' => $gympassId,
            ]);

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()];
            }

            Log::error('Gympass Validation Failed', ['status' => $response->status(), 'body' => $response->body()]);
            return ['success' => false, 'error' => $response->body()];

        } catch (\Exception $e) {
            Log::error('Gympass Validation Exception: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
