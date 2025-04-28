<?php

namespace App\DesignPatterns\Creational\Factory\Payment;

class PaymentGatewayFactory
{
    public static function create($type)
    {
        return match ($type) {
            'square' => new SquareGateway(),
            'stripe' => new StripeGateway(),
            'paypal' => new PayPalGateway(),
            default => throw new \Exception("Invalid payment gateway type"),
        };
        // switch ($type) {
        //     case 'square':
        //         return new SquareGateway();
        //     case 'stripe':
        //         return new StripeGateway();
        //     case 'paypal':
        //         return new PayPalGateway();
        //     default:
        //         throw new \Exception("Invalid payment gateway type");
        // }
    }
}
