<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $fillable = [
        'message', 'reply',
    ];
    
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
