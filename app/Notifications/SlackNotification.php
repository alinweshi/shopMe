<?php

namespace App\Notifications;

use Illuminate\Http\JsonResponse;
use App\Interfaces\NotificationInterface;

class SlackNotification implements NotificationInterface
{
    public function send(string $to, string $message): JsonResponse
    {
        return response()->json(['message' => "Sending slack notification to $to: $message"]);
    }
}
