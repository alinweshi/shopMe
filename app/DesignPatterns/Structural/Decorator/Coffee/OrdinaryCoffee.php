<?php

namespace App\DesignPatterns\Structural\Decorator\Coffee;

use App\DesignPatterns\Structural\Decorator\Coffee\CoffeeInterface;

class OrdinaryCoffee implements CoffeeInterface
{
    public function getCost(): float
    {
        return  15.50;
    }
    public function getDescription(): string
    {
        return "Ordinary Coffee";
    }
}
