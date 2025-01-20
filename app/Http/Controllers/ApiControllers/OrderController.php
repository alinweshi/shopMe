<?php

namespace App\Http\Controllers\ApiControllers;

use App\Interfaces\Payments\PaymentServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected PaymentServiceInterface $paymentService;

    public function __construct(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function store(CreateOrderRequest $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $cart = Cart::with('cartItems')->where('user_id', $user->id)->first();

            if (!$cart || $cart->cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty.',
                ], 400);
            }

            // Delegate order creation to a service
            $order = app()->make(OrderService::class)->createOrderFromCart($cart, $request);
            // dd($order);
            //here you created the order and now you need to send the payment request to the payment gateway
            //you should prepare the payment data and send it to the payment gateway

            // Prepare payment data
            // $paymentData = $this->preparePaymentData($user, $order);

            // // Initiate payment
            // $response = $this->paymentService->sendPayment($paymentData, $order->id);
            // // dd($response);
            // // dd($response['Data']['InvoiceId']);

            // // Update order with invoice details
            // $order->invoice_number = $response['Data']['InvoiceId'];
            // $order->save();
            // dd($order);
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully.',
                'data' => $order,
                // 'payment_url' => $response['Data']['InvoiceURL'],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your order.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    private function preparePaymentData($user, $order): array
    {
        return [
            'CustomerName' => $user->first_name . ' ' . $user->last_name,
            'NotificationOption' => 'LNK',
            'CustomerMobile' => $user->phone,
            'InvoiceValue' => $order->total_price,
            'CallBackUrl' => config('services.myfatoorah.callback_url'),
            'ErrorUrl' => config('services.myfatoorah.error_url'),
            'Language' => 'en',
            'DisplayCurrencyIso' => 'KWD',
            'MobileCountryCode' => '965',
            'CustomerEmail' => $user->email,
            'CustomerReference' => $user->id,
            'InvoiceItems' => $order->items->map(fn($item) => [
                'ItemName' => $item->product->name,
                'Quantity' => $item->quantity,
                'UnitPrice' => $item->unit_price,
                'TotalPrice' => $item->total_price,
            ])->toArray(),
        ];
    }
    public function index()
    {
        try {
            $user = Auth::user();
            $orders = Order::where('user_id', $user->id)->get();
            return response()->json([
                'success' => true,
                'data' => $orders
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching your orders.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
