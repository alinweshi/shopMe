<?php

namespace App\DesignPatterns\Structural\Adapter;

class ApplepayPayment
{

    public function makePayment(float $amount): void
    {
        echo "Processing Applepay payment of $amount\n";
    }
}
