<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment',
        'user_id',
        'rating'
        ];



    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
