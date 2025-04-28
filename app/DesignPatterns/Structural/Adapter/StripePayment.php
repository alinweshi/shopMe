<?php

namespace App\DesignPatterns\Structural\Adapter;

class StripePayment implements PaymentInterface
{
    public function processPayment(float $amount): void
    {
        echo "Processing Stripe payment of $amount\n";
    }
}
