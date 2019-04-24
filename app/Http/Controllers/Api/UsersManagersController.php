<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManager\UserManagerDestroy;
use App\User;
use Spatie\Permission\Models\Role;

/**
 * Class UsersManagersController.
 *
 * @package App\Http\Controllers
 */
class UsersManagersController extends Controller
{
    public function destroy(UserManagerDestroy $request,User $user)
    {
        $user->removeRole(Role::findByName('Manager','web'));
        return $user;
    }
}
