<?php

namespace App\Services;

use App\Models\Order;
use GuzzleHttp\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Interfaces\Payments\PaymentServiceInterface;

class MyFatoorahService implements PaymentServiceInterface
{
    protected $token;
    protected $initiatedPaymentApiUrl;
    protected $executedPaymentApiUrl;
    protected $sendPaymentApiUrl;
    protected $getPaymentStatusApiUrl;
    protected $updatePaymentStatusApiUrl;

    public function __construct()
    {
        $this->token = config('services.myfatoorah.token');
        $this->initiatedPaymentApiUrl = config('services.myfatoorah.initiate_payment_url');
        $this->executedPaymentApiUrl = config('services.myfatoorah.execute_payment_url');
        $this->sendPaymentApiUrl = config('services.myfatoorah.send_payment_url');
        $this->getPaymentStatusApiUrl = config('services.myfatoorah.get_payment_status_url');
        $this->updatePaymentStatusApiUrl = config('services.myfatoorah.update_payment_status_url');
    }

    public function sendPayment(array $paymentData, int $orderId): array
    {

        $response = Http::withToken($this->token)
            ->withOptions(['verify' => false])
            ->post($this->sendPaymentApiUrl, $paymentData);


        if ($response->failed()) {
            Log::error('Failed to send payment', ['order_id' => $orderId, 'response' => $response->body()]);
            throw new \Exception('Failed to send payment.');
        }
        $order = Order::find($orderId);
        $order->invoice_number = $response['Data']['InvoiceId'];
        $order->save();
        return $response->json();
    }

    public function initiatePayment($invoiceAmount, $currencyIso, $invoiceNumber): array
    {
        $response = Http::withToken($this->token)
            ->post($this->initiatedPaymentApiUrl, [
                'InvoiceAmount' => $invoiceAmount,
                'CurrencyIso' => $currencyIso,
                'InvoiceNumber' => $invoiceNumber,
            ]);

        if ($response->failed()) {
            throw new \Exception('Failed to initiate payment: ' . $response->body());
        }

        return $response->json();
    }

    public function executePayment(array $data): array
    {
        $response = Http::withToken($this->token)->post($this->executedPaymentApiUrl, $data);

        if ($response->failed()) {
            Log::error('Failed to execute payment', ['data' => $data, 'response' => $response->body()]);
            throw new \Exception('Failed to execute payment.');
        }

        return $response->json();
    }

    public function getPaymentStatus(array $data): array
    {
        try {
            $response = Http::withToken($this->token)
                ->withOptions(['verify' => false])
                ->post($this->getPaymentStatusApiUrl, $data);

            if ($response->failed()) {
                Log::error('Failed to fetch payment status', ['data' => $data, 'response' => $response->body()]);
                return ['IsSuccess' => false, 'Message' => 'Failed to fetch payment status.'];
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error in getPaymentStatus', ['error' => $e->getMessage()]);
            return ['IsSuccess' => false, 'Message' => 'An error occurred while fetching payment status.'];
        }
    }


    public function updatePaymentStatus(array $data): array
    {
        try {
            if (empty($data['paymentId'])) {
                throw new \Exception('PaymentId is required.');
            }

            $apiData = [
                'Operation' => 'Capture',
                'Key' => $data['paymentId'],
                'KeyType' => 'PaymentId',
            ];

            $response = Http::withToken($this->token)->post($this->updatePaymentStatusApiUrl, $apiData);

            if ($response->failed()) {
                Log::error('Failed to update payment status', ['response' => $response->body()]);
                throw new \Exception('Failed to update payment status.');
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error in updatePaymentStatus', ['error' => $e->getMessage()]);
            throw $e; // Re-throw to be handled by the caller
        }
    }

    public function saveTransactionData(array $data): array
    {
        try {
            $response = $this->getPaymentStatus($data);
            // dd($response);

            // dd($response);
            $order = Order::where('invoice_number', $response['Data']['InvoiceId'])->first();
            // dd($response['Data']['InvoiceId']);
            $order->status = 'completed';
            $order->save();

            $invoiceData = $response['Data'];

            // Save transactions
            foreach ($invoiceData['InvoiceTransactions'] as $transactionDatum) {
                $transaction = new Transaction();
                $transaction->transactionable_id = $transactionDatum['TransactionId'];
                $transaction->transactionable_type = 'App\Models\Payment';
                $transaction->invoice_number = $response['Data']['InvoiceId'];
                $transaction->status = strtolower($transactionDatum['TransactionStatus']);
                $transaction->subtotal = $invoiceData['InvoiceValue'] - $transactionDatum['VatAmount'];
                $transaction->net_total = $invoiceData['InvoiceValue'];
                $transaction->tax = $transactionDatum['VatAmount'];
                $transaction->currency = $transactionDatum['Currency'];
                $transaction->billed_at = $invoiceData['CreatedDate'];
                $transaction->save();
            }

            return [
                'success' => 'Transaction data saved successfully',
                'data' => $response['Data'],
            ];
        } catch (\Exception $e) {
            Log::error('Failed to save transaction data', ['error' => $e->getMessage()]);
            // throw new \Exception('Failed to save transaction data.');
        }
    }

    public function getPaymentURL(array $data): array
    {
        $response = $this->initiatePayment($data['InvoiceValue'], $data['Currency'], $data['InvoiceId']);

        return [
            'payment_url' => $response['Data']['PaymentURL'],
        ];
    }
}
