<?php

namespace App\DesignPatterns\Creational\Factory\Notifications;

class NotificationFactory
{
    public static function create($notificationType)
    {
        switch ($notificationType) {
            case 'email':
                return new EmailNotification();
            case 'sms':
                return new SmsNotification();
            case 'whatsapp':
                return new WhatsappNotification();
            default:
                throw new \Exception('Invalid notification type');
        }
    }
}
