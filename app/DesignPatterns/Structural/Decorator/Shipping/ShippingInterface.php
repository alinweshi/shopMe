<?php

namespace App\DesignPatterns\Structural\Decorator\Shipping;

interface ShippingInterface
{
    public function getShippingCost(): float;
    public function getDescription(): string;
}
