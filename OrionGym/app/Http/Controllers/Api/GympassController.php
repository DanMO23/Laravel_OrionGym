<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GympassService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GympassController extends Controller
{
    protected $gympassService;

    public function __construct(GympassService $gympassService)
    {
        $this->gympassService = $gympassService;
    }

    /**
     * Recebe o webhook do Gympass.
     */
    public function webhook(Request $request)
    {
        Log::info('Gympass Webhook Received', $request->all());

        try {
            $checkin = $this->gympassService->processCheckinWebhook($request->all());
            
            return response()->json(['message' => 'Webhook processed', 'id' => $checkin ? $checkin->id : null], 200);
        } catch (\Exception $e) {
            Log::error('Gympass Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing webhook'], 500);
        }
    }
}
