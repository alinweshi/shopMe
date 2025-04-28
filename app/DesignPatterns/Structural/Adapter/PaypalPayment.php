<?php

namespace App\DesignPatterns\Structural\Adapter;

class PaypalPayment implements PaymentInterface
{
    public function processPayment(float $amount): void
    {
        echo "Processing Paypal payment of $amount\n";
    }
}
