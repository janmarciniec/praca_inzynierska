<?php

namespace App\Policies;

use App\Item;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
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
     * @param  \App\Item  $item
     * @return mixed
     */
    public function view(User $user, Item $item)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //administrator nie może dodawać ogłoszeń
        return $user->username != 'admin';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Item  $item
     * @return mixed
     */
    public function update(User $user, Item $item)
    {
        //edytować ogłoszenie może tylko ten użytkownik, który je dodał
        //przedmiot musi być dostępny (nie można edytować ogłoszenia kupionego przedmiotu)
        return $user->id == $item->user_id && ($item->availability == 1);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Item  $item
     * @return mixed
     */
    public function delete(User $user, Item $item)
    {
        //usunąć ogłoszenie może tylko ten użytkownik, który je dodał lub administrator
        //przedmiot musi być dostępny (nie można usunąć ogłoszenia kupionego przedmiotu)
        return ($user->id == $item->user_id || $user->username == 'admin') && $item->availability == 1;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Item  $item
     * @return mixed
     */
    public function restore(User $user, Item $item)
    {
        //przywrócić ogłoszenie może tylko ten użytkownik, który je dodał
        //przedmiot musi być niedostępny, aby móc go przywrócić
        return $user->id == $item->user_id && $item->availability == 0;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Item  $item
     * @return mixed
     */
    public function forceDelete(User $user, Item $item)
    {
        //
    }
    
    public function buy(User $user, Item $item)
    {
        //kupić przedmiot może tylko ten użytkownik którego id jest różne od id użytkownika w ogłoszeniu (nie można kupić własnego przedmiotu)
        //przedmiot musi być dostępny (nie można kupić przedmiotu więcej niż raz)
        //użytkownik musi mieć przynajmniej jeden token
        return ($user->id != $item->user_id) && ($item->availability == 1) && ($user->tokens > 0);
    }
    
    public function transfer(User $user, Item $item)
    {
        //przenieść ogłoszenie do innej kategorii może administrator
        //przedmiot musi być dostępny
        return $user->username == 'admin' && $item->availability == 1;
    }
}
