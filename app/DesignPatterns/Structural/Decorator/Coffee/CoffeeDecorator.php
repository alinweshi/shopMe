<?php

namespace App\DesignPatterns\Structural\Decorator\Coffee;

use App\DesignPatterns\Structural\Decorator\Coffee\CoffeeInterface;

class CoffeeDecorator implements CoffeeInterface
{
    public function __construct(public CoffeeInterface $coffee) {}
    public function getCost(): float
    {
        return $this->coffee->getCost();
    }
    public function getDescription(): string
    {
        return $this->coffee->getDescription();
    }
}
