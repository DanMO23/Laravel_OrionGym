<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\Api\GympassController;

// Rotas Gympass
Route::post('/gympass/webhook', [GympassController::class, 'webhook']);

// Rotas Integração Catraca
Route::prefix('turnstile')->group(function () {
    Route::get('/ping', [TurnstileController::class, 'ping']);
    Route::get('/commands/pending', [TurnstileController::class, 'pendingCommands']);
    Route::post('/commands/{id}/confirm', [TurnstileController::class, 'confirmCommand']);
    Route::post('/events', [TurnstileController::class, 'handleEvent']);
    Route::get('/users/pending-sync', [TurnstileController::class, 'pendingSyncUsers']);
    Route::post('/users/{id}/synced', [TurnstileController::class, 'confirmUserSync']);
});
