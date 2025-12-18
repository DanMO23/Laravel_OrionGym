<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class GympassIntegrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    /**
     * Test webhook reception and validation.
     */
    public function test_webhook_reception_and_validation(): void
    {
        // Mock do usuário
        $user = User::factory()->create([
            'gympass_id' => '1234567890123',
            'is_gympass' => true,
        ]);

        // Mock da API do Gympass
        Http::fake([
            '*/access/v1/validate' => Http::response(['result' => 'ok'], 200),
        ]);

        // Payload do Webhook (simulado)
        $payload = [
            'event_id' => 'evt_123',
            'user' => [
                'id' => '1234567890123',
            ],
            'timestamp' => now()->toIso8601String(),
        ];

        // Enviar requisição
        $response = $this->postJson('/api/gympass/webhook', $payload);

        // Asserções
        $response->assertStatus(200);
        
        $this->assertDatabaseHas('gympass_checkins', [
            'gympass_id' => 'evt_123',
            'user_id' => $user->id,
            'status' => 'approved',
        ]);

        // Verificar se a API foi chamada
        Http::assertSent(function ($request) {
            return $request->url() == config('gympass.base_url') . '/access/v1/validate' &&
                   $request['gympass_id'] == '1234567890123';
        });
    }
}
