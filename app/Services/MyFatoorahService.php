<?php

namespace App\Services;

use App\Models\Payment;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MyFatoorahService
{
    private $base_url;
    private $headers;
    private $client_request;
    private $data;
    public function __construct(Client $client_request)
    {
        $this->base_url = env('MYFATOORAH_BASE_URL');
        $this->headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('MYFATOORAH_API_KEY'),
        ];
        $this->client_request = $client_request;
        $this->data['errorUrl'] = env("MYFATOORAH_ERROR_URL");
        $this->data['CallBackUrl'] = env("MYFATOORAH_SUCCESS_URL");
    }

    public function buildRequest($url, $method, $data = [])
    {
        $response = $this->client_request->request($method, $this->base_url . $url, [
            'headers' => $this->headers,
            'json' => $data,
        ]);
        $response = json_decode($response->getBody()->getContents());
        return $response;
    }

    public function sendPayment($data)
    {
        $data['errorUrl'] = $this->data['errorUrl'];
        $data['CallBackUrl'] = $this->data['CallBackUrl'];
        return $this->buildRequest('/v2/SendPayment', 'POST', $data);
    }
    public function getPaymentStatus($data)
    {
        return $response = $this->buildRequest('/v2/GetPaymentStatus', 'POST', $data);
    }
    public function saveTransactionData($request)
    {

        $response = $this->getPaymentStatus(['Key' => $request->paymentId, 'KeyType' => 'PaymentId']);

        $transactionData = $response->Data->InvoiceTransactions;

        foreach ($transactionData as $transactionDatum) {
            $transaction = new Payment();
            $transaction->transaction_id = $transactionDatum->TransactionId;
            $transaction->total_price = $response->Data->InvoiceValue;
            $transaction->transaction_status = $transactionDatum->TransactionStatus;
            $transaction->payment_gate = $transactionDatum->PaymentGateway;
            $transaction->failing_reason = $transactionDatum->ErrorCode;
            $transaction->save();
        }

    }

}
