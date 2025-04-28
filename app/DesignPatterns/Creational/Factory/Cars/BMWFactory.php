<?php

namespace App\DesignPatterns\Creational\Factory\Cars;

class BMWFactory implements CarBrandFactoryInterface
{
    public function build()
    {
        return new BMW();
    }
}
