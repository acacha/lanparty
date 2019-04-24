<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Managers\ManagersIndex;
use App\Role;
use App\User;

/**
 * Class ManagersController.
 *
 * @package App\Http\Controllers
 */
class ManagersController extends Controller
{
    /**
     * @return mixed
     */
    public function index(ManagersIndex $request)
    {
        $managers = Role::findByName('Manager')->users;
        $users = User::users();
        return view('manage.managers.index', compact('managers','users'));
    }
}
