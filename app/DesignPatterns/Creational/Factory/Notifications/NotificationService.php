<?php

use App\DesignPatterns\Creational\Factory\Notifications\NotificationInterface;

namespace App\DesignPatterns\Creational\Factory\Notifications;

class NotificationService
{
    public function send($type, $message): void
    {
        $notification = NotificationFactory::create($type);
        $notification->send($message);
    }
}
