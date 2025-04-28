<?php

namespace App\DesignPatterns\Creational\Factory\Cars;

class MercedesFactory implements CarBrandFactoryInterface
{
    public function build()
    {
        return new Mercedes();
        /*
            class Mercedes implements CarBrandsInterface
            {
                public function createBrand()
                {
                    return 'mercedes';
                }
            }
        */
    }
}
