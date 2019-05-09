<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\RegistrationsAreEnabled;
use App\Prize;
use App\Partner;

/**
 * Class WelcomeController.
 *
 * @package App\Http\Controllers
 */
class WelcomeController extends Controller
{
    use RegistrationsAreEnabled;

    /**
     * Welcome page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $prizes = Prize::with(['partner'])->where('session', config('lanparty.session') )->get();
        $partners = Partner::with('prizes')->where('session', config('lanparty.session') )->get();
        return view('welcome',[
           'prizes' => $prizes,
           'partners' => $partners,
           'registrations_enabled' => $this->registrationsAreEnabled()
       ]);
    }

}
