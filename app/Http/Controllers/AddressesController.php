<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth','verified']);
    }
    
    public function edit()
    {
        $this->authorize('update', Address::class); 
        
        return view('addresses.edit');
    }
    
    public function update()
    {
        $this->authorize('update', Address::class); 
        
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
        
        auth()->user()->address->update($data);
        
        $notification = array(
                    'message' => 'Adres został zaktualizowany',
                    'alert-type' => 'success'
                );

        return redirect()->route('user.index')->with($notification);
    }
}
