<?php

namespace App\DesignPatterns\Behavioural\Strategy;


interface  PaymentStrategyInterface
{
    public function processPayment(float $amount): void;
}
