<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

/**
 * Class UsersController.
 *
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    /**
     * Return all users
     */
    public function index()
    {
        return map_collection(User::with(['numbers','events'])->withCount('ticket')->get());
    }

    /**
     * Update user.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->only(['name','email','givenName','sn1','sn2']));
    }
}
