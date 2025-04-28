<?php

namespace App\DesignPatterns\Structural\Decorator\Shipping;

class SuperFastShipping extends ShippingDecorator
{
    public function getCost()

    {
        return parent::getShippingCost() + 10.0;
    }
    public function getDescription(): string
    {
        return parent::getDescription() . ' with super fast shipping';
    }
}
