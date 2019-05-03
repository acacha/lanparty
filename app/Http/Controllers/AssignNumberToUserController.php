<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignNumberToUserDestroy;
use App\Http\Requests\AssignNumberToUserStore;
use App\Number;
use App\User;

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
     * @return
     */
    public function store(AssignNumberToUserStore $request, User $user)
    {
        $number = Number::firstAvailableNumber($request->session)->assignUser($user);
        $number->description = $request->description;
        $number->save();
        return $number;
    }


    /**
     * Unassign number to user
     *
     * @param AssignNumberToUserDestroy $request
     * @param Number $number
     * @return Number
     */
    public function destroy(AssignNumberToUserDestroy $request, Number $number)
    {
        $number->user_id = null;
        $number->save();
        return $number;
    }
}
