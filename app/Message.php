<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'message',
        'conversation_id',
        'user_id'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
