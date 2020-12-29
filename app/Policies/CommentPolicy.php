<?php

namespace App\Policies;

use App\Claim;
use App\Comment;
use App\Transaction;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function view(User $user, Comment $comment)
    {
        //zgłoszenie może zobaczyć tylko autor zgłoszenia lub administrator
        return $user->id == $comment->transaction->user->id || $user->username == 'admin';
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Transaction $transaction)
    {

        return $user->id == $transaction->user->id && $transaction->comment == null;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        //tylko admin może odpowiadać na zgłoszenia
        //na jedno zgłoszenie można odpowiedzieć tylko raz
        return $user->username == 'admin' && $comment->reply == null;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comment $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comment $comment
     * @return mixed
     */
    public function restore(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comment $comment
     * @return mixed
     */
    public function forceDelete(User $user, Comment $comment)
    {
        //
    }
}
