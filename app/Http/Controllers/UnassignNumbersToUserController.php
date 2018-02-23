<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnassignNumberToUser;
use App\User;
use Illuminate\Http\Request;

/**
 * Class UnassignNumbersToUserController.
 *
 * @package App\Http\Controllers
 */
class UnassignNumbersToUserController extends Controller
{
    /**
     * Unassign all numbers to user.
     *
     * @return mixed
     */
    public function store(UnassignNumberToUser $request, User $user)
    {
        foreach ($user->numbers as $number) {
            $number->update([ 'user_id' => null]);
            $number->save();
        }
    }
}
