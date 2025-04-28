<?php

namespace App\Http\Controllers\Broadcast;

use App\Models\User;
use App\Models\Message;
use App\Events\UserIsTyping;
use App\Events\SendChatMessage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\sendMessageRequest;

class ChatController extends Controller
{
    public function index()
    {
        // Fetch all active users
        $users = User::all();
        // dump($users);
        return view('chats.index', compact('users'));
    }
    public function chat($receiverId)
    {
        // Fetch messages for the chat
        $messages = Message::where(
            function ($query) use ($receiverId) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $receiverId);
            }
        )->orWhere(
            function ($query) use ($receiverId) {
                $query->where('sender_id', $receiverId)
                    ->where('receiver_id', Auth::id());
            }
        )->orderBy('created_at', 'desc')
            ->with(['sender', 'receiver'])->take(5)->get();


        $receiver = User::find($receiverId);
        // dd(Auth::id());
        // dd($messages);
        // dd(Message::where('receiver_id', $receiverId)->get());
        return view('chats.chat', compact(['messages', 'receiverId', 'receiver']));
    }

    public function sendMessage(sendMessageRequest $request, $receiverId)
    {
        try {

            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $receiverId,
                'content' => $request->message,
            ]);

            // dd($message);

            // Store message in database

            // Broadcast message to other users
            broadcast(new SendChatMessage($message))->toOthers();

            return response()->json(['message' => 'Message sent successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send message'], 500);
        }
    }
    public function typing()
    {
        // dd(Auth::user());
        broadcast(new UserIsTyping(Auth::id()))->toOthers();
        return response()->json(['message' => 'User is typing...'], 200);
    }
    public function online()
    {
        Cache::put('user:online-' . auth()->id, true, now()->addMinutes(5));
        return response()->json(['message' => 'User is online'], 200);
    }
    public function offline()
    {
        Cache::forget('user:online-' . auth()->id);
        return response()->json(['message' => 'User is offline'], 200);
    }
}
