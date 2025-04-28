<?php

namespace App\DesignPatterns\Creational\Factory\Payment;

use App\DesignPatterns\Creational\Factory\Payment\PaymentGatewayInterface;

class SquareGateway implements PaymentGatewayInterface
{
    public function processPayment(float $amount): void
    {
        echo "Processing payment of $$amount via Square.\n";
    }

    public function refundPayment(float $amount): void
    {
        echo "Refunding payment of $$amount via Square.\n";
    }
}
