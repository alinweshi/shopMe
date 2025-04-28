<?php

namespace App\DesignPatterns\Creational\Factory\Notifications;

interface NotificationInterface
{
    public function send($message): void;
}
