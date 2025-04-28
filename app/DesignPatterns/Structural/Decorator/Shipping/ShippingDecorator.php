<?php

namespace App\DesignPatterns\Structural\Decorator\Shipping;

class ShippingDecorator implements ShippingInterface
{
    public function __construct(public ShippingInterface $shipping) {}

    public function getShippingCost(): float
    {
        return $this->shipping->getShippingCost();
    }
    public function getDescription(): string
    {
        return $this->shipping->getDescription();
    }
}
