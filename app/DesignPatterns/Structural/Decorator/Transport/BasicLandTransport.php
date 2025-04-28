<?php

namespace App\DesignPatterns\Structural\Decorator\Transport;

class BasicLandTransport implements TransportInterface
{
    public function getTransportCost(): float
    {
        return 100.0;
    }
    public function getDescription(): string
    {
        return 'Basic land transport';
    }
}
