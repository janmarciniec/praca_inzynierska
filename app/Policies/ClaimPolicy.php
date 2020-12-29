<?php

namespace App\Policies;

use App\Claim;
use App\User;
use App\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClaimPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //tylko admin może przeglądać zgłoszenia
        return $user->username == 'admin';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Claim  $claim
     * @return mixed
     */
    public function view(User $user, Claim $claim)
    {
        //zgłoszenie może zobaczyć tylko autor zgłoszenia lub administrator
        return $user->id == $claim->transaction->user->id || $user->username == 'admin';
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Transaction $transaction)
    {
        //zgłoszenie może wysłać tylko użytkownik, który kupił przedmiot
        //można wysłać tylko jedno zgłoszenie do danej transakcji

        return $user->id == $transaction->user->id && $transaction->claim == null;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Claim  $claim
     * @return mixed
     */
    public function update(User $user, Claim $claim)
    {
        //tylko admin może odpowiadać na zgłoszenia
        //na jedno zgłoszenie można odpowiedzieć tylko raz
        return $user->username == 'admin' && $claim->reply == null;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Claim  $claim
     * @return mixed
     */
    public function delete(User $user, Claim $claim)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Claim  $claim
     * @return mixed
     */
    public function restore(User $user, Claim $claim)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Claim  $claim
     * @return mixed
     */
    public function forceDelete(User $user, Claim $claim)
    {
        //
    }
}
