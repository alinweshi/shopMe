<?php

namespace App\DesignPatterns\Behavioural\Strategy;

use App\DesignPatterns\Behavioural\Strategy\PaymentStrategyInterface;

class PaypalStrategy implements PaymentStrategyInterface
{
    public function processPayment(float $amount): void
    {
        echo "Processing payment of $$amount via PayPal.\n";
    }
}
