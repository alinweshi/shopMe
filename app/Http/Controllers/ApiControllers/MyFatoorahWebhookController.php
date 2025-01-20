<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Services\MyFatoorahWebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MyFatoorahWebhookController extends Controller
{
    private MyFatoorahWebhookService $webhookService;

    public function __construct(MyFatoorahWebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    /**
     * Handle the webhook request
     */
    public function handle(Request $request)
    {
        $body = $request->getContent();
        $signature = $request->header('MyFatoorah-Signature');
        // dd($signature);
        $secret = env('MYFATOORAH_WEBHOOK_SECRET_KEY');

        // Log the incoming request
        Log::info('Webhook Received', ['body' => $body]);

        // Validate the signature
        if (! $this->webhookService->validateSignature($body, $secret, $signature)) {
            Log::error('Invalid webhook signature');

            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Process the webhook event
        $data = json_decode($body, true);
        try {
            $this->webhookService->handleEvent($data);
        } catch (\Exception $e) {
            Log::error('Error handling webhook event', ['message' => $e->getMessage()]);

            return response()->json(['error' => 'Internal server error'], 500);
        }

        return response()->json(['message' => 'Webhook processed successfully'], 200);
    }
}
