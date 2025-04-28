<?php

namespace App\DesignPatterns\Creational\Factory\Payment;

interface PaymentGatewayInterface
{
    public function processPayment(float $amount): void;
    public function refundPayment(float $amount): void;
}
