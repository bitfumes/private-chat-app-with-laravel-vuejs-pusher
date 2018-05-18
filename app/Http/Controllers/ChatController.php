<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Resources\ChatResource;

class ChatController extends Controller
{
    public function send(Session $session, Request $request)
    {
        $message = $session->messages()->create(['content' => $request->content]);

        $message->createForSend($session->id);

        $message->createForReceive($session->id, $request->to_user);

        return response($message, 200);
    }

    public function chats(Session $session)
    {
        return ChatResource::collection($session->chats->where('user_id', auth()->id()));
    }
}
