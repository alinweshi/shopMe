<?php

// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $token = env('MYFATOORAH_TOKEN');
        $client = new Client();

        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'currency_iso' => 'required|string|max:3',
            'mobile_country_code' => 'required|string|max:5',
            'customer_mobile' => 'required|string|max:15',
            'customer_email' => 'required|email|max:255',
            'invoice_value' => 'required|numeric|min:0',
            'payment_method_id' => 'required|exists:shipping_methods,id',
            'coupon_code' => 'nullable|string|max:255',
        ]);

        $body = [
            "PaymentMethodId" => $validatedData['payment_method_id'],
            "CustomerName" => $validatedData['customer_name'],
            "DisplayCurrencyIso" => $validatedData['currency_iso'],
            "MobileCountryCode" => $validatedData['mobile_country_code'],
            "CustomerMobile" => $validatedData['customer_mobile'],
            "CustomerEmail" => $validatedData['customer_email'],
            "InvoiceValue" => $validatedData['invoice_value'],
            "CallBackUrl" => route('payment.success'),
            "ErrorUrl" => route('payment.error'),
            "Language" => "EN",
            "CustomerReference" => "order-" . uniqid(),
            "InvoiceItems" => $this->prepareInvoiceItems($request->cartItems), // Ensure cartItems are passed in the request
        ];

        try {
            $response = $client->post('https://apitest.myfatoorah.com/v2/ExecutePayment', [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                    'Content-Type' => 'application/json'
                ],
                'json' => $body,
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);
            Log::info('Payment Response:', $responseBody);

            if (isset($responseBody['IsDirectPayment']) && $responseBody['IsDirectPayment']) {
                return redirect()->away($responseBody['PaymentURL']);
            }

            session()->flash('message', 'Proceeding to payment!');
            return redirect()->route('payment.redirect', ['payment_url' => $responseBody['PaymentURL'] ?? '']);

        } catch (\Exception $e) {
            Log::error('Payment Processing Error:', ['exception' => $e->getMessage()]);
            session()->flash('error', 'Payment processing error. Please try again.');
        }
    }

    private function prepareInvoiceItems($cartItems)
    {
        return collect($cartItems)->map(callback: function ($item) {
            return [
                "ItemName" => $item['product_name'],
                "Quantity" => $item['quantity'],
                "UnitPrice" => $item['total_price'],
            ];
        })->toArray();
    }
    // Handle payment success
    public function success(Request $request)
    {
        // Here you can handle the logic for successful payment
        return view('payment.success'); // Ensure you have a success view
    }

    // Handle payment failure
    public function error(Request $request)
    {
        // Here you can handle the logic for failed payment
        return view(view: 'payment.error'); // Ensure you have an error view
    }
}
