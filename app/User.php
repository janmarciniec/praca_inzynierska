<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName', 'surname', 'username', 'email', 'password', 'tokens', 'registerUrl',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        //tworzenie adresu podczas tworzenia użytkownika
        static::created(function($user) {
            $user->address()->create([
                'firstName' => $user->firstName,
                'surname' => $user->surname,
            ]);
        });
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class)->orderBy('created_at','DESC');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('created_at','DESC');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at','DESC');
    }
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'receiver_id')->orderBy('created_at','DESC');
    }


}
