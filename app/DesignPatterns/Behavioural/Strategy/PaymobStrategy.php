<?php

namespace App\DesignPatterns\Behavioural\Strategy;

class PaymobStrategy implements PaymentStrategyInterface
{
    public function processPayment(float $amount): void
    {
        echo "Processing payment of $$amount via Paymob.\n";
    }
}
