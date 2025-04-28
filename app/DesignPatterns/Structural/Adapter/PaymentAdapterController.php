<?php

namespace App\DesignPatterns\Structural\Adapter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentAdapterController extends Controller
{
    public function processPayment($paymentMethod, float $amount)
    {
        // dd($paymentMethod, $amount);
        $paymentProcessor = new PaymentContext($paymentMethod);
        return $paymentProcessor->processPayment($amount);
    }
}
