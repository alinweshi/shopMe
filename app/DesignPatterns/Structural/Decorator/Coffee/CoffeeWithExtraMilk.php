<?php

namespace App\DesignPatterns\Structural\Decorator\Coffee;

use App\DesignPatterns\Structural\Decorator\Coffe\CoffeeInterface;

class CoffeeWithExtraMilk extends CoffeeDecorator
{
    public function getCost(): float
    {
        return parent::getCost() + 0.5;
        // return  $this->coffee->getCost() + 0.5;
    }
    public function getDescription(): string
    {
        // return $this->coffee->getDescription() . ' with extra milk';
        return parent::getDescription() . ' with extra milk';
    }
}
