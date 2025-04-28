<?php

namespace App\DesignPatterns\Creational\Factory\Notifications;

use Illuminate\Http\Request;

class NotificationController
{
    protected $notification;
    public function __construct(NotificationService $notification)
    {
        $this->notification = $notification;
    }
    public function send(Request $request)
    {
        $type = $request->input('type');
        $message = $request->input('message');
        $this->notification->send($type, $message);
    }
}
