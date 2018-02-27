<?php

namespace App\Http\Controllers;

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
//        return User::with('events:name,image')->get();
        return UserResource::collection(User::all());
    }
}
