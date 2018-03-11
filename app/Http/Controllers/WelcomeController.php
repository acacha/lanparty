<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class WelcomeController.
 *
 * @package App\Http\Controllers
 */
class WelcomeController extends Controller
{
    /**
     * Welcome page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('welcome')->with('registrations_enabled', $this->registrationsAreEnabled() ? true : false);
    }

    /**
     * Check if registrations are enabled.
     *
     * @return bool
     */
    protected function registrationsAreEnabled()
    {
        return Carbon::parse(config('lanparty.registration_start_date'))->isPast();
    }
}
