<?php

namespace App\DesignPatterns\Creational\Factory\Payment;

class StripeGateway implements PaymentGatewayInterface
{
    public function processPayment(float $amount): void
    {
        echo "Processing payment of $$amount via Stripe.\n";
    }

    public function refundPayment(float $amount): void
    {
        echo "Refunding payment of $$amount via Stripe.\n";
    }
}
