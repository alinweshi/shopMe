<?php

namespace App\DesignPatterns\Creational\Factory\Payment;

use App\DesignPatterns\Creational\Factory\Payment\PaymentGatewayInterface;

class PayPalGateway implements PaymentGatewayInterface
{
    public function processPayment(float $amount): void
    {
        echo "Processing payment of $$amount via PayPal.\n";
    }

    public function refundPayment(float $amount): void
    {
        echo "Refunding payment of $$amount via PayPal.\n";
    }
}
