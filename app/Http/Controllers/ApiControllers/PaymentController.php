<?php

namespace App\Http\Controllers\ApiControllers;

use App\Jobs\ProcessPayment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Interfaces\Payments\PaymentServiceInterface;

class PaymentController extends Controller
{
    protected PaymentServiceInterface $paymentService;

    public function __construct(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function handleCallback(Request $request): JsonResponse
    {
        try {
            $paymentId = $request->get('paymentId');
            $data = ['key' => $paymentId, 'KeyType' => 'PaymentId'];

            $paymentData = $this->paymentService->saveTransactionData($data);

            return response()->json([
                'success' => true,
                'data' => $paymentData,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to handle payment callback.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getPaymentStatus(Request $request): JsonResponse
    {
        log::info('Payment status request data', ['data' => $request->all()]);
        try {
            if ($request->has('paymentId')) {
                $paymentId = $request->get('paymentId');
                $data = ['key' => $paymentId, 'KeyType' => 'PaymentId'];
            } else if ($request->has('invoiceId')) {
                $invoiceId = $request->get('invoiceId');
                $data = ['key' => $invoiceId, 'KeyType' => 'InvoiceId'];
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment ID or Invoice ID is required.',
                ], 400);
            }
            // Ensure the paymentId is present in the request



            $paymentStatus = $this->paymentService->getPaymentStatus($data);

            return response()->json([
                'success' => true,
                'data' => $paymentStatus,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get payment status.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function sendPayment(Request $request): JsonResponse
    {
        Log::info('Payment request data', ['data' => $request->all()]);

        try {
            $data = $request->all();
            $orderId = $request->orderId;


            $paymentData = $this->paymentService->sendPayment($data, $orderId);
            ProcessPayment::dispatch($data);
            Log::info('Payment response data', ['data' => $paymentData]);
            return response()->json([
                'success' => true,
                'data' => $paymentData,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send payment request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
