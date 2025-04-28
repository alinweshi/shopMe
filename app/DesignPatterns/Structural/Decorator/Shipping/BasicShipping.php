<?php

namespace App\DesignPatterns\Structural\Decorator\Shipping;

class BasicShipping implements ShippingInterface
{
    public function getShippingCost(): float
    {
        return 10.0;
    }
    public function getDescription(): string
    {
        return "we are shipping your order";
    }
}
