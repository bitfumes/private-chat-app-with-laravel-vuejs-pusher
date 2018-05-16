<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
