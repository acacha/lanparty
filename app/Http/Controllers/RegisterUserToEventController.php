<?php

namespace App\Http\Controllers;

use App\Event;
use App\Exceptions\InscriptionException;
use App\Exceptions\UserAlreadyInscribedException;
use App\Http\Requests\RegisterUserToEventRequest;
use App\User;

/**
 * Class RegisterUserToEventController.
 *
 * @package App\Http\Controllers
 */
class RegisterUserToEventController extends Controller
{
    /**
     * Register user to event.
     *
     * @param RegisterUserToEventRequest $request
     * @param Event $event
     * @param User $user
     */
    public function store(RegisterUserToEventRequest $request, Event $event, User $user)
    {
        try {
            $event->registerUser($user);
        } catch(UserAlreadyInscribedException $e) {
            abort(422,"L'usuari ja està apuntat a l'esdeveniment!");
        } catch(InscriptionException $e) {
            abort(422,$e->getMessage());
        }
    }

    /**
     * Unregister user to an event.
     */
    public function destroy(RegisterUserToEventRequest $request, Event $event, User $user)
    {
        $event->unregisterUser($user);
    }
}
