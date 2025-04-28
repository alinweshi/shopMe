<?php

namespace App\DesignPatterns\Behavioural\Strategy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderStrategyController extends Controller
{
    public function pay(Request $request)
    {
        $paymentProcessor = new PaymentProcessorContext($request->input('payment_method'));
        return $paymentProcessor->processPayment(100);
    }
}
