<?php

namespace App\DesignPatterns\Behavioural\Strategy;

class StripeStrategy implements PaymentStrategyInterface
{
    public function processPayment(float $amount): void
    {
        echo "Processing payment of $$amount via Stripe.\n";
    }
}
