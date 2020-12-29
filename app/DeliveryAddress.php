<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    protected $fillable = [
        'firstName', 'surname', 'street', 'number', 'flat', 'postalCode', 'city', 'phoneNumber',
    ];
    
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
