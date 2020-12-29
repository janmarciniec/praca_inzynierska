<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'item_id', 'status',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryAddress()
    {
        return $this->hasOne(DeliveryAddress::class);
    }

    public function claim()
    {
        return $this->hasOne(Claim::class);
    }
    public function comment()
    {
        return $this->hasOne(Comment::class);
    }
}
