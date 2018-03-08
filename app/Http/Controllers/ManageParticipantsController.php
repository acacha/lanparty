<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManagePartipantsRequest;
use App\Http\Resources\NumberWithUserResource;
use App\Http\Resources\UserResource;
use App\Number;
use App\User;
use Auth;

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
    public function index(ManagePartipantsRequest $request)
    {
        $users = collect(UserResource::collection(User::with(['ticket','events','roles','numbers'])->withCount('ticket')->get())->resolve());
        $numbers = collect(NumberWithUserResource::collection(Number::with(['user'])->get())->resolve());
        return view('manage.participants', [
            'user' => Auth::user(),
            'users' => $users,
            'numbers' => $numbers,
        ]);
    }
}
