<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\DeliveryAddress;
use Illuminate\Http\Request;

class DeliveryAddressesController extends Controller
{
    public function create(Transaction $transaction)
    {
        $this->authorize('create', [DeliveryAddress::class, $transaction]);
        
        return view('deliveryAddresses.create', compact('transaction'));
    }
    
    public function store(Transaction $transaction)
    {
        $data = request() -> validate([
            'firstName' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:255'],
            'flat' => ['max:255'],
            'postalCode' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'phoneNumber' => ['max:255'],
        ]);
        
        $transaction->deliveryAddress()->create($data);
        
        //czy checkbox saveAddress został zaznaczony
        if(request()->get('saveAddress') != null)
        {
            auth()->user()->address->update($data);
        }
        
        return redirect()->route('transaction.confirm', $transaction);
    }
}
