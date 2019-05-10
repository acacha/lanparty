<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RegistrationsAreEnabled;
use App\Partner;
use App\Prize;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

/**
 * Class ResetPasswordController.
 *
 * @package App\Http\Controllers\Auth
 */
class ResetPasswordController extends Controller
{
    use RegistrationsAreEnabled;

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        $prizes = Prize::with(['partner'])->where('session', config('lanparty.session') )->get();
        $partners = Partner::with('prizes')->where('session', config('lanparty.session') )->get();
        return view('welcome')->with([
            'prizes' => $prizes,
            'partners' => $partners,
            'token' => $token,
            'email' => $request->email,
            'action' => 'reset_password',
            'registrations_enabled' => $this->registrationsAreEnabled()
        ]);
    }
}
