<?php

namespace App\Http\Controllers;

use App\Event;
use App\Exceptions\InscriptionException;
use App\Exceptions\UserAlreadyInscribedException;
use Auth;
use Illuminate\Http\Request;

/**
 * Class RegisterToEventController.
 *
 * @package App\Http\Controllers
 */
class RegisterToEventController extends Controller
{
    /**
     * Register current logged user to an event
     */
    public function store(Event $event)
    {
        try {
            $event->registerUser(Auth::user());
        } catch(UserAlreadyInscribedException $e) {
            abort(422,"L'usuari ja està apuntat al esdeveniment!");
        } catch(InscriptionException $e) {
            abort(422,$e->getMessage());
        }
    }

    /**
     * Unregister current logged user to an event
     */
    public function destroy(Event $event)
    {
        $event->unregisterUser(Auth::user());
    }
}
