<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::USER;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstName' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $tokens = 0;
        
        //bonusowe 5 tokenów dla 3 pierwszych użytkowników 
        if(User::count() < 3)
        {
            $tokens += 5;
        }

        //jeśli użytkownik rejestruje się z linku polecającego
        if($data['invitingKey'] != null)
        {
            //wyszukanie użytkownika o podanym invitingKey
            $user = User::all()->where('invitingKey', $data['invitingKey'])->first();
            
            //jeśli użytkownik o podanym invitingKey istnieje
            if($user != null)
            {
                //dodanie 3 bonusowych tokenów użytkownikowi, który rejestruje się z linku polecającego
                $tokens += 3;
            }
        }
        
        return User::create([
            'firstName' => $data['firstName'],
            'surname' => $data['surname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'tokens' => $tokens,
        ]);
    }
    
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm($invitingKey = null)
    {
        return view('auth.register', compact('invitingKey'));
    }
}
