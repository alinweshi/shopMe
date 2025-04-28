<?php

namespace App\DesignPatterns\Structural\Decorator\Shipping;

class FastShipping extends ShippingDecorator
{
    public function getShippingCost(): float
    {
        return parent::getShippingCost() + 5.0;
    }
    public function getDescription(): string
    {
        return parent::getDescription() . ' with fast shipping';
    }
}
