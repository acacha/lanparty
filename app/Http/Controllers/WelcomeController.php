<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\RegistrationsAreEnabled;

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
        return view('welcome')->with('registrations_enabled', $this->registrationsAreEnabled());
    }

}
