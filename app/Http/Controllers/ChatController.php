<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Resources\ChatResource;
use App\Events\PrivateChatEvent;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function send(Session $session, Request $request)
    {
        $message = $session->messages()->create(['content' => $request->content]);

        $chat = $message->createForSend($session->id);

        $message->createForReceive($session->id, $request->to_user);

        broadcast(new PrivateChatEvent($message->content, $chat));

        return response($message, 200);
    }

    public function chats(Session $session)
    {
        return ChatResource::collection($session->chats->where('user_id', auth()->id()));
    }

    public function read(Session $session)
    {
        $chats = $session->chats->where('read_at', null)->where('type', 0)->where('user_id', '!=', auth()->id());

        foreach ($chats as $chat) {
            $chat->update(['read_at'=> Carbon::now()]);
        }
    }
}
