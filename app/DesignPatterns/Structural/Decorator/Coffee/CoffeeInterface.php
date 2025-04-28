<?php

namespace App\DesignPatterns\Structural\Decorator\Coffee;


interface CoffeeInterface
{
    public function getCost(): float;
    public function getDescription(): string;
}
