<?php

namespace App\DesignPatterns\Structural\Decorator\Transport;

use App\Http\Controllers\Controller;

class TransportDecoratorController extends Controller
{
    public function transport()
    {
        $transport = new BasicLandTransport();
        $transport = new AirTransport($transport);
        // $transport = new SeaTransport($transport);
        return $transport->getDescription() . ' : ' . $transport->getTransportCost();
    }
}
