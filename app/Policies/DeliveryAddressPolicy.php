<?php

namespace App\Policies;

use App\DeliveryAddress;
use App\User;
use App\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryAddressPolicy
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
     * @param  \App\DeliveryAddress  $deliveryAddress
     * @return mixed
     */
    public function view(User $user, DeliveryAddress $deliveryAddress)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Transaction $transaction)
    {
        //adres dostawy może dodać tylko użytkownik, który kupił przedmiot
        //adres dostawy można dodać tylko raz do jednej transakcji
        //nie można dodać adresu dostawy do potwierdzonej transakcji
        return $user->id == $transaction->user_id && $transaction->deliveryAddress == null && $transaction->status == 'unconfirmed';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryAddress  $deliveryAddress
     * @return mixed
     */
    public function update(User $user, DeliveryAddress $deliveryAddress)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryAddress  $deliveryAddress
     * @return mixed
     */
    public function delete(User $user, DeliveryAddress $deliveryAddress)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryAddress  $deliveryAddress
     * @return mixed
     */
    public function restore(User $user, DeliveryAddress $deliveryAddress)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryAddress  $deliveryAddress
     * @return mixed
     */
    public function forceDelete(User $user, DeliveryAddress $deliveryAddress)
    {
        //
    }
}
