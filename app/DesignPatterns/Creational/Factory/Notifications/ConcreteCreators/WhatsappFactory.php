<?php

namespace App\DesignPatterns\Creational\Factory\Notifications\ConcreteCreators;

use App\DesignPatterns\Creational\Factory\Notifications\SmsNotification;
use App\DesignPatterns\Creational\Factory\Notifications\WhatsappNotification;

class WhatsappFactory implements NotificationFactoryInterface
{
    public static function createNotification()
    {
        return new WhatsappNotification();
    }
}
