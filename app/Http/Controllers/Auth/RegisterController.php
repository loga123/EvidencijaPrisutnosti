<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;//dodano za autentifikaciju admina(rovjeru korisnika)
use Mockery\Matcher\Closure;

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
    protected $redirectTo = '/';
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');  //auth ako je korisnik prijavljen inače guest da se može bilo tko prijaviti
    }

    public function admin()
    {
        return view('auth/register');
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
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'kartica' => 'required|numeric',

        ],[
            //Custom error poruke
            'ime.required' => 'Niste unijeli ime!',
            'ime.max' => 'Ime može imati maksimalno 255 znakova!',
            'ime.string' => 'Ime mora biti u tekstualnom obliku!',
            'prezime.required' => 'Niste unijeli prezime!',
            'prezime.max' => 'Prezime može imati maksimalno 255 znakova!',
            'prezime.string' => 'Prezime mora biti u tekstualnom obliku!',
            'email.required' => 'Niste unijeli e-mail!',
            'email.email' => 'Molimo unesite valjanju e-mail adresu!',
            'email.max' => 'E-mail može imati maximalno 255 znakova!',
            'email.unique' => 'Postoji korisnik u sustav s takvom e-mail adresom!',
            'password.required' => 'Niste unijeli lozinku!',
            'password.min' => 'Lozinka mora imati minimalno 6 znakova!',
            'password.confirmed' => 'Lozinke se ne podudaraju!',
            'kartica.required' => 'Niste unijeli broj X-ice!',
            'kartica.numeric' => 'Broj X-ice mora biti u brojčanom formatu!',

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'ime' => $data['ime'],
            'prezime' => $data['prezime'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'broj_iskaznice' => $data['kartica'],
            'razina_prava' => 3,

        ]);
    }
}
