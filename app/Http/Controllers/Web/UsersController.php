<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UsersIndex;
use App\Role;
use App\User;

/**
 * Class UsersController.
 *
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    /**
     * @return mixed
     */
    public function index(UsersIndex $request)
    {
        $users = User::users();
        return view('manage.users.index', compact('users'));
    }
}
