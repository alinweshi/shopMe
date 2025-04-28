<?php

namespace App\DesignPatterns\Creational\Factory\Cars;

class BMW implements CarBrandsInterface
{
    public function createBrand()
    {
        return "BMW";
    }
}
