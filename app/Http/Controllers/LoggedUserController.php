<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

/**
 * Class LoggedUserController.
 *
 * @package App\Http\Controllers
 */
class LoggedUserController extends Controller
{
    /**
     * Update user.
     *
     * @param Request $request
     * @return bool
     */
    public function update(Request $request)
    {
        Auth::user()->update($request->only(['name','email','givenName','sn1','sn2']));
        return Auth::user();
    }
}
