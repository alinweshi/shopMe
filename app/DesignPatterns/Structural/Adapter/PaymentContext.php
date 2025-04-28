<?php

namespace App\DesignPatterns\Structural\Adapter;


use App\DesignPatterns\Structural\Adapter\PaypalPayment;
use App\DesignPatterns\Structural\Adapter\StripePayment;

class PaymentContext
{
    private PaymentInterface $payment;
    public function __construct(string $paymentMethod)
    {
        $this->payment = match ($paymentMethod) {
            'applepay' => new ApplepayAdapter(new ApplepayPayment()),
            'stripe' => new StripePayment(),
            'paypal' => new PaypalPayment(),
            default => new StripePayment(),
        };
    }
    public function processPayment(float $amount): void
    {
        $this->payment->processPayment($amount);
    }
}
