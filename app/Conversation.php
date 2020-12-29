<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    public $contact;
    protected $fillable = [
        'sender_id',
        'receiver_id'
    ];
 public function messages()
 {
     return $this->hasMany(Message::class, 'conversation_id');
 }
 public function users()
    {
        return $this->belongsTo(User::class);
    }
}
