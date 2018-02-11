<?php

namespace App\Http\Controllers;

use App\Event;
use Auth;
use Illuminate\Http\Request;

/**
 * Class ParticipantsMainPageController.
 *
 * @package App\Http\Controllers
 */
class ParticipantsMainPageController extends Controller
{
    /**
     * Main view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $events = Event::all();
        return view('home', [
            'events' => $events,
            'user' => Auth::user(),
        ]);
    }
}
