<?php

namespace App\DesignPatterns\Structural\Adapter;

class ApplepayAdapter implements PaymentInterface
{
    public function __construct(private ApplepayPayment $applepayPayment) {}
    public function processPayment(float $amount): void
    {
        $this->applepayPayment->makePayment($amount);
    }
}
