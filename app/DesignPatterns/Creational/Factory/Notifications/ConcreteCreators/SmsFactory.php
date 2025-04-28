<?php

namespace App\DesignPatterns\Creational\Factory\Notifications\ConcreteCreators;

use App\DesignPatterns\Creational\Factory\Notifications\SmsNotification;

class SmsFactory implements NotificationFactoryInterface
{
    public static function createNotification()
    {
        return new SmsNotification();
    }
}
