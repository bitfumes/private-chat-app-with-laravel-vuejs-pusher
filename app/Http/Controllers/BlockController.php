<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Events\BlockEvent;

class BlockController extends Controller
{
    public function block(Session $session)
    {
        $session->block();
        broadcast(new BlockEvent($session->id, true));
        return response(null, 201);
    }

    public function unblock(Session $session)
    {
        $session->unblock();
        broadcast(new BlockEvent($session->id, false));
        return response(null, 201);
    }
}
