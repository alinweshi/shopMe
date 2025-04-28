<?php

namespace App\DesignPatterns\Structural\Adapter;

interface PaymentInterface
{
    public function processPayment(float $amount): void;
}
