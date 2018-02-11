<?php

namespace App\Http\Controllers;

use App\Number;
use App\User;
use Auth;
use Illuminate\Http\Request;

/**
 * Class ManageParticipantsController
 * @package App\Http\Controllers
 */
class ManageParticipantsController extends Controller
{
    /**
     * Manage participants.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::with('numbers')->get();
        $numbers = Number::with('user')->get();
        return view('manage.participants', [
            'user' => Auth::user(),
            'users' => $users,
            'numbers' => $numbers,
        ]);
    }
}
