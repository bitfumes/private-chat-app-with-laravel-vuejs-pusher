<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded = [];

    protected $casts = [
        'read_at' => 'datetime'
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
