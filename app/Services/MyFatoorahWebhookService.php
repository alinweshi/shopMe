<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class MyFatoorahWebhookService
{
    private $secret;

    public function __construct()
    {
        $this->secret = config('services.myfatoorah.secret');
    }

    /**
     * Validate the webhook signature
     */
    public function validateSignature(string $body, string $secret, string $signature): bool
    {
        $data = json_decode($body, true);

        // Remove specific keys based on the event type
        $this->sanitizeEventData($data);

        // Order and prepare the data for hashing
        $orderedData = $this->prepareOrderedData($data['Data']);

        // Generate the hash
        $hash = $this->generateHash($orderedData, $this->secret);

        // Log the generated and received signatures for debugging
        Log::info('Generated Signature: '.$hash);
        Log::info('Received Signature: '.$signature);

        return $hash === $signature;
    }

    /**
     * Handle the webhook event
     */
    public function handleEvent(array $data)
    {
        $event = $data['Event'] ?? null;
        $eventData = $data['Data'] ?? [];

        if (method_exists($this, $event)) {
            $this->{$event}($eventData);
        } else {
            Log::warning("Unknown event type: $event");
        }
    }

    /**
     * Sanitize event data by removing specific keys
     */
    private function sanitizeEventData(array &$data)
    {
        $removableKeys = [
            'RefundStatusChanged' => ['GatewayReference'],
            'SupplierStatusChanged' => ['KycFeedback'],
            'TransactionsStatusChanged' => ['GatewayReference'],
        ];

        $event = $data['Event'] ?? null;
        if (isset($removableKeys[$event])) {
            foreach ($removableKeys[$event] as $key) {
                unset($data['Data'][$key]);
            }
        }
    }

    /**
     * Prepare ordered data for hashing
     */
    private function prepareOrderedData(array $data): string
    {
        uksort($data, 'strcasecmp');

        return implode(',', array_map(
            fn ($v, $k) => sprintf('%s=%s', $k, $v),
            $data,
            array_keys($data)
        ));
    }

    /**
     * Generate a hash using HMAC SHA-256
     */
    private function generateHash(string $data, string $secret): string
    {
        return base64_encode(hash_hmac('sha256', $data, $secret, true));
    }

    /**
     * Handle TransactionsStatusChanged event
     */
    private function TransactionsStatusChanged(array $data)
    {
        Log::info('Transaction Status Changed', $data);
    }

    /**
     * Handle RefundStatusChanged event
     */
    private function RefundStatusChanged(array $data)
    {
        Log::info('Refund Status Changed', $data);
    }

    /**
     * Handle other events as needed
     */
    private function SupplierStatusChanged(array $data)
    {
        Log::info('Supplier Status Changed', $data);
    }
}
