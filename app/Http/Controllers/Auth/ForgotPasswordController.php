<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RegistrationsAreEnabled;
use App\Partner;
use App\Prize;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

/**
 * Class ForgotPasswordController.
 *
 * @package App\Http\Controllers\Auth
 */
class ForgotPasswordController extends Controller
{
    use RegistrationsAreEnabled;

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $prizes = Prize::with(['partner'])->where('session', config('lanparty.session') )->get();
        $partners = Partner::with('prizes')->where('session', config('lanparty.session') )->get();
        return view('welcome', [
            'prizes' => $prizes,
            'partners' => $partners,
            'action' => 'request_new_password',
            'registrations_enabled' => $this->registrationsAreEnabled()
        ]);
    }

}
