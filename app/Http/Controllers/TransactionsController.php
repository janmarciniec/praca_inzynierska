<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Mail\SoldItemMail;
use App\Mail\BoughtItemMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TransactionsController extends Controller
{
    public function confirm(Transaction $transaction)
    {
        $this->authorize('confirm', $transaction);
        
        return view('transactions.confirm', compact('transaction'));
    }
    
    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);
        
        return view('transactions.show', compact('transaction'));
    }
    
    public function save(Transaction $transaction)
    {
        //transakcja zatwierdzona, zmiana statusu ogłoszenia na niedostępne
        $transaction->item->update(['availability' => 0]);
        
        //zmniejszenie liczby tokenów kupującego
        $transaction->user->update(['tokens' => $transaction->user->tokens - 1]);
                
        //zwiększenie liczby tokenów sprzedawcy
        $transaction->item->user->update(['tokens' => $transaction->item->user->tokens + 1]);
        
        //zmiana statusu transakcji na potwierdzona
        $transaction->update(['status' => 'confirmed']);
        
        //co ósmą transakcję kupujący otrzymije bonusowe dwa tokeny
        if($transaction->user->transactions->where('status', 'confirmed')->count()%8 == 0)
        {
            $transaction->user->update(['tokens' => $transaction->user->tokens + 2]);
            
            $notification = array(
                    'message' => 'Gratulujemy częstych zakupów w serwisie Baster! Otrzymujesz w prezencie 1 token',
                    'alert-type' => 'success'
                );
        }
        else {
            $notification = array(
                    'message' => 'Przedmiot został kupiony za 1 token',
                    'alert-type' => 'success'
                );
        }
        
        //wysłanie maila do sprzedawcy
        Mail::to($transaction->item->user->email)->send(new SoldItemMail($transaction));
        //wysłanie maila do kupującego
        Mail::to($transaction->user->email)->send(new BoughtItemMail($transaction));

        return redirect()->route('item.show', $transaction->item_id)->with($notification);
    }
    
    public function destroy(Transaction $transaction)
    {
        $item_id = $transaction->item_id;
        $transaction->delete();

        return redirect()->route('item.show', $item_id);
    }
}
