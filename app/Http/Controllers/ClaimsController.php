<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Claim;
use App\Mail\ClaimReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ClaimsController extends Controller
{
    public function create(Transaction $transaction)
    {
        $this->authorize('create', [Claim::class, $transaction]);
        
        return view('claims.create', compact('transaction'));
    }
    
    public function store(Transaction $transaction)
    {
        $data = request()->validate([
            'message' => ['required', 'string', 'max:255'],
        ]);
        
        $transaction->claim()->create($data);
        
        $notification = array(
                    'message' => 'Zgłoszenie zostało wysłane',
                    'alert-type' => 'success'
                );
        
        return redirect()->route('user.index')->with($notification);
    }
    
    public function show(Claim $claim)
    {        
        $this->authorize('view', $claim);
        
        return view('claims.show', compact('claim'));
    }
    
    public function index()
    {
        $this->authorize('viewAny', Claim::class);
        
        $claims = Claim::orderBy('created_at','DESC')->get();
        
        return view('claims.index', compact('claims'));
    }
    
    public function edit(Claim $claim)
    {       
        $this->authorize('update', $claim);
        
        return view('claims.edit', compact('claim'));
    }
    
    public function update(Claim $claim)
    {
        $this->authorize('update', $claim);
        
        $data = request()->validate([
            'reply' => ['required', 'string', 'max:255'],
        ]);
             
        $claim->update($data);
        
        Mail::to($claim->transaction->user->email)->send(new ClaimReplyMail($claim));
        
        $notification = array(
                    'message' => 'Odpowiedź na zgłoszenie została wysłana',
                    'alert-type' => 'success'
                );

        return redirect()->route('claim.show', $claim)->with($notification);
    }
}
