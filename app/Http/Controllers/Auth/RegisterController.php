<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Traits\RegistrationsAreEnabled;
use App\Partner;
use App\Prize;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

/**
 * Class RegisterController.
 *
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    use RegistrationsAreEnabled;

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
    protected $redirectTo = '/home';

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'givenName' => 'required|string',
            'sn1' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $prizes = Prize::with(['partner'])->where('session', config('lanparty.session') )->get();
        $partners = Partner::with('prizes')->where('session', config('lanparty.session') )->get();
        return view('welcome', [
            'prizes' => $prizes,
            'partners' => $partners,
            'action' => 'register',
            'registrations_enabled' => $this->registrationsAreEnabled()
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'givenName' => $data['givenName'],
            'sn1' => $data['sn1'],
            'sn2' => $data['sn2'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
