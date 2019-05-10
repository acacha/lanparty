<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RegistrationsAreEnabled;
use App\Partner;
use App\Prize;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * Class LoginController.
 *
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    use RegistrationsAreEnabled;

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $prizes = Prize::with(['partner'])->where('session', config('lanparty.session') )->get();
        $partners = Partner::with('prizes')->where('session', config('lanparty.session') )->get();
        return view('welcome', [
            'prizes' => $prizes,
            'partners' => $partners,
            'action' => 'login',
            'registrations_enabled' => $this->registrationsAreEnabled()
        ]);
    }

}
