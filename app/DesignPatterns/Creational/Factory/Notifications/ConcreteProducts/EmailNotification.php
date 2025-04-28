<?php

namespace App\DesignPatterns\Creational\Factory\Notifications;

use App\DesignPatterns\Creational\Factory\Notifications\NotificationInterface;

class EmailNotification implements NotificationInterface
{
    public function send($message): void
    {
        // Send SMS notification using an SMS gateway
        echo "Sending SMS notification: $message";
    }
}
