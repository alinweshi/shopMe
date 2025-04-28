<?php

namespace App\DesignPatterns\Structural\Decorator\Transport;

class SeaTransport  extends AbstractTransportDecorator
{
    public function getTransportCost(): float
    {
        return parent::getTransportCost() + 100.0;
    }
    public function getDescription(): string
    {
        return parent::getDescription() . ' with sea transport';
    }
}
