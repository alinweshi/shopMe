<?php

namespace App\DesignPatterns\Creational\Factory\Cars;

class Mercedes implements CarBrandsInterface
{
    public function createBrand()
    {
        return 'mercedes';
    }
}
