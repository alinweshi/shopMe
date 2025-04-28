<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{userId}', function ($user, $userId) {
    // dd($user->id, $userId);
    return true;
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('typing.{userId}', function ($user, $userId) {
    return true;
});
