<?php

namespace App\Http\Controllers;

use App\User;
use App\Invitation;
use Illuminate\Http\Request;

class InvitationsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Invitation::class); 
        
        $url = url("")."/register/".auth()->user()->invitingKey;
        
        return view('invitations.index', compact('url'));
    }
}