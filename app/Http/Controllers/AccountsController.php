<?php

namespace App\Http\Controllers;

use App\User;
use App\Claim;
use App\Mail\CreateMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AccountsController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth','verified']);
    }
    
    public function index()
    {
        $this->authorize('viewAny', Claim::class);
        
        $users = User::where('username', '!=', 'admin')->orderBy('created_at','DESC')->get();
        
        return view('accounts.index', compact('users'));
    }
    
    public function update(User $user)
    {
        $data = request() -> validate([
            'tokens' => ['required', 'integer'],
        ]);
        
        $user->update($data);
        
        $notification = array(
                    'message' => 'Liczba tokenów użytkownika została zmieniona',
                    'alert-type' => 'success'
                );
        
        return redirect()->route('accounts.index')->with($notification);
    }
    
    public function sendMail(User $user)
    {
        $data = request()->validate([
            'subject' => ['required', 'string', 'max:200'],
            'content' => ['required', 'string'],
        ]);
        
        $subject = $data['subject'];
        $content = $data['content'];
        
        Mail::to($user->email)->send(new CreateMail($subject, $content));
        
        $notification = array(
                    'message' => 'Wiadomość została wysłana na aders e-mail użytkownika',
                    'alert-type' => 'success'
                );
        
        return redirect()->route('accounts.index')->with($notification);
    }
}
