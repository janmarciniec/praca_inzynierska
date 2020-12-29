<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'firstName', 'surname', 'street', 'number', 'flat', 'postalCode', 'city', 'phoneNumber',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
