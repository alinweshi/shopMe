<?php

namespace App\DesignPatterns\Structural\Decorator\Transport;

abstract class AbstractTransportDecorator implements TransportInterface
{
    public function __construct(public TransportInterface $transport) {}
    public function getTransportCost(): float
    {
        return $this->transport->getTransportCost();
    }
    public function getDescription(): string
    {
        return $this->transport->getDescription();
    }
}
