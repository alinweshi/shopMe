<?php

namespace App\Http\Controllers\ApiControllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Factories\NotificationFactory;

class NotificationController extends Controller
{
    public function send(Request $request, $type, $to)
    {

        $message = $request->get('message', 'default message');
        $notification = NotificationFactory::create($type);
        // dd($notification);
        return $notification->send($to, $message);
    }
}
