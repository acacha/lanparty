<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Managers\ManagersIndex;
use App\Http\Requests\UserManager\UserManagerDestroy;
use App\User;
use Spatie\Permission\Models\Role;

/**
 * Class ManagersController.
 *
 * @package App\Http\Controllers
 */
class ManagersController extends Controller
{
    public function index(ManagersIndex $request)
    {
        try {
            return Role::findByName('Manager','web')->users;
        } catch (\Exception $e) {
            return collect([]);
        }

    }
}
