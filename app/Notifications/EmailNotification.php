<?php

namespace App\Notifications;

use Illuminate\Http\JsonResponse;
use App\Interfaces\NotificationInterface;

class EmailNotification implements NotificationInterface
{
    public function send(string $to, string $message): JsonResponse
    {
        return response()->json(['message' => "Sending email notification to $to: $message"]);
    }
}
