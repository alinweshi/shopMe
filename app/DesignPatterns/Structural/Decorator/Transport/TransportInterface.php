<?php

namespace App\DesignPatterns\Structural\Decorator\Transport;

interface TransportInterface
{
    public function getTransportCost(): float;
    public function getDescription(): string;
}
