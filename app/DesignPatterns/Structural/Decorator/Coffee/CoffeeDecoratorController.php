<?php

namespace App\DesignPatterns\Structural\Decorator\Coffee;

use App\Http\Controllers\Controller;

class CoffeeDecoratorController extends Controller
{
    public function MakeCoffeeCost()
    {
        $coffee = new OrdinaryCoffee();
        $coffee = new CoffeeWithExtraMilk($coffee);
        return $coffee->getCost();
    }
}
