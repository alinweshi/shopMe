<?php

namespace App\DesignPatterns\Creational\Factory\Notifications;

use App\DesignPatterns\Creational\Factory\Notifications\NotificationInterface;


class NotificationService
{
    public function send($type, $message): void
    {
        $notification = NotificationFactory::create($type);
        $notification->send($message);
    }
}
