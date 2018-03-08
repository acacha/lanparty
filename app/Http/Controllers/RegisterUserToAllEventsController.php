<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserToEventRequest;
use App\User;
use Illuminate\Http\Request;

/**
 * Class RegisterUserToAllEventsController.
 *
 * @package App\Http\Controllers
 */
class RegisterUserToAllEventsController extends Controller
{
    /**
     * Unregister user to all events.
     *
     * @param RegisterUserToEventRequest $request
     * @param User $user
     */
    public function destroy(RegisterUserToEventRequest $request, User $user)
    {
        foreach ($user->events as $event) {
            $event->unregisterUser($user);
        }
    }
}
