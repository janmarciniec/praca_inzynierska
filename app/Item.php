<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'title', 'description', 'location', 'category_id', 'image', 'availability',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
