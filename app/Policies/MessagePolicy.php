<?php

namespace App\Policies;

use App\Conversation;
use App\Transaction;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function create(User $user)
    {
     return $user->id == $user->id;
    }
    public function view(User $user)
    {
        return $user->id == $user->id;
    }
    public function show(User $user, Conversation $conversation)
    {
        return $user->id == $conversation->receiver_id || $user->id == $conversation->sender_id;
    }
}
