<?php

namespace App\DesignPatterns\Structural\Decorator\Transport;

class AirTransport extends AbstractTransportDecorator
{
    public function getTransportCost(): float
    {
        return parent::getTransportCost() + 200.0;
    }
    public function getDescription(): string
    {
        return parent::getDescription() . ' with air transport';
    }
    // public function getDescription(): string
    // {
    //     return 'Air transport';
    // }

    // public function getTransportCost(): float
    // {
    //     return 200.0;
    // }
}
