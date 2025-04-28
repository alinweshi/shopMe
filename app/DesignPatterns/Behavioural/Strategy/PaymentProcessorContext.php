<?php

namespace App\DesignPatterns\Behavioural\Strategy;

class PaymentProcessorContext
{
    private PaymentStrategyInterface $paymentStrategy;
    public function __construct(string $paymentMethod)
    {
        $this->paymentStrategy = match ($paymentMethod) {
            'stripe' => new StripeStrategy(),
            'paypal' => new PaypalStrategy(),
            'paymob' => new PaymobStrategy(),
            default => new StripeStrategy(),
        };
    }


    public function processPayment(float $amount): void
    {
        $this->paymentStrategy->processPayment($amount);
    }
}
