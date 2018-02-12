<?php

namespace App\Http\Controllers;

use App\Event;
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
        $event->registerUser(Auth::user());
    }
}
