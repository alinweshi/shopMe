<?php

namespace App\DesignPatterns\Creational\Factory\Notifications\ConcreteCreators;

use App\DesignPatterns\Creational\Factory\Notifications\SmsNotification;
use App\DesignPatterns\Creational\Factory\Notifications\EmailNotification;

class EmailFactory implements NotificationFactoryInterface
{
    public static function createNotification()
    {
        return new EmailNotification();
    }
}
