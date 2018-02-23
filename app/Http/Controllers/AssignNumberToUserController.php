<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignNumberToUser;
use App\Number;
use App\User;
use Illuminate\Http\Request;

/**
 * Class AssignNumberToUserController.
 *
 * @package App\Http\Controllers
 */
class AssignNumberToUserController extends Controller
{
    /**
     * Assign first available number to user.
     *
     * @param User $user
     */
    public function store(AssignNumberToUser $request, User $user)
    {
        $number = Number::firstAvailableNumber()->assignUser($user);
        $number->description = $request->description;
        $number->save();
        return $number;
    }
}
