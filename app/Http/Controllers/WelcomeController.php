<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

/**
 * Class WelcomeController.
 *
 * @package App\Http\Controllers
 */
class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome', [ 'user' => Auth::user()]);
    }
}
