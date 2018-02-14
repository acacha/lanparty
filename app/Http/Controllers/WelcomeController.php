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
        return view('welcome');
    }
}
