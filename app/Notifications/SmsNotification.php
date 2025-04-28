<?php

namespace App\Notifications;

use Illuminate\Http\JsonResponse;
use App\Interfaces\NotificationInterface;

class SmsNotification implements NotificationInterface
{

    public function send(string $to, string $message): JsonResponse
    {
        return response()->json(['message' => "Sending sms notification to $to: $message"]);
    }
}
