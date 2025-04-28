<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface NotificationInterface
{
    public function send(string $to, string $message): JsonResponse;
}
