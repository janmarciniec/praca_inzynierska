<?php

namespace App\Http\Controllers;

Use App\User;
Use App\Item;
use App\Mail\DeleteAccountMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function edit()
    {
        return view('users.edit');
    }
    
    public function update()
    {
        $data = request() -> validate([
            'firstName' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
        ]);
        
        auth()->user()->update($data);
        
        //jeśli użytkownik nie podał nazwy ulicy, to znaczy że nie ingerował w adres
        //domyślnie w adresie powinny znajdować się imię i nazwisko podane przy rejestracji - te dane się zaktualizują
        //w przeciwnym wypadku, gdy użytkownik ma już ustawiony adres, zmiana danych konta nie wpływa na zmianę adresu
        if(auth()->user()->address->street == null)
        {
            //Zaktualizowanie danych w adresie
            auth()->user()->address->update($data);
        }
        
        $notification = array(
                    'message' => 'Profil został zaktualizowany',
                    'alert-type' => 'success'
                );

        return redirect()->route('user.index')->with($notification);
    }
    
    public function items(User $user)
    {
        $items = Item::where('user_id', $user->id)->where('availability', 1)->orderBy('created_at','DESC')->paginate(16);
        
        return view('users.items', compact('user', 'items'));
    }
    
    public function destroy(User $user)
    {
        $this->authorize('delete', $user); 

        //usunięcie wszystkich ogłoszeń przedmiotów użytkownika, które nie zostały sprzedane
        foreach($user->items->where('availability', 1) as $item)
        {
            $item->delete();
        }
        
        $user->delete();
        
        $notification = array(
                    'message' => 'Konto zostało usunięte',
                    'alert-type' => 'success'
                );
        
        //jeśli admin usunął konto, zostanie wysłany mail do użytkownika, którego konto zostało uzunięte
        if(auth()->user()->username == 'admin')
        {
            $data = request()->validate([
                'explanation' => ['required', 'string'],
            ]);
            
            $explanation = $data['explanation'];
            
            Mail::to($user->email)->send(new DeleteAccountMail($explanation));
            return redirect()->route('accounts.index')->with($notification);
        }

        return redirect()->route('home')->with($notification);
    }
}
