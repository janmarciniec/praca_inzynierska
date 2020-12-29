<?php

namespace App\Policies;

use App\Transaction;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return mixed
     */
    public function view(User $user, Transaction $transaction)
    {
        //szczegóły transakcji może przeglądać tylko użytkownik, który sprzedał przedmiot
        //jeśli konto użytkownika, którry kupił przedmiot zostało usunięte, to nie można wyświetlić szczegółów transakcji
        return $user->id == $transaction->item->user->id && $transaction->user_id != null;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return mixed
     */
    public function update(User $user, Transaction $transaction)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return mixed
     */
    public function delete(User $user, Transaction $transaction)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return mixed
     */
    public function restore(User $user, Transaction $transaction)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return mixed
     */
    public function forceDelete(User $user, Transaction $transaction)
    {
        //
    }
    
    public function confirm(User $user, Transaction $transaction)
    {
        //potwierdzić transakcję może tylko użytkownik, który kupił przedmiot
        //nie można potwierdzić jednej transakcji więcej niż raz
        //nie można potwierdzić różnych transakcji dotyczących jednego przedmiotu (jeśli jest kilka niepotwierdzonych transakcji dotyczących jednego przedmiotu, to można potwierdzić tylko jedną z nich)
        return $transaction->user_id != null && $user->id == $transaction->user->id && $transaction->status == 'unconfirmed' && $user->transactions->where('item_id', $transaction->item_id)->every(function ($value, $key) { return $value->status == 'unconfirmed'; }) == true;
    }
}
