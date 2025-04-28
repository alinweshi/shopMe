<?php

namespace App\Factories;

use App\Notifications\SmsNotification;
use App\Notifications\EmailNotification;
use App\Notifications\SlackNotification;
use App\Interfaces\NotificationInterface;

class NotificationFactory
{
    public static function create($type): NotificationInterface
    {
        return match ($type) {
            'email' => new EmailNotification(),
            'sms' => new SmsNotification(),
            'slack' => new SlackNotification(),
            default => throw new \Exception('Invalid notification type')
        };
    }
}
