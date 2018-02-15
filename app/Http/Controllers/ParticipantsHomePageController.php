<?php

namespace App\Http\Controllers;

use App\Event;
use Auth;
use Illuminate\Http\Request;

/**
 * Class ParticipantsHomePageController.
 *
 * @package App\Http\Controllers
 */
class ParticipantsHomePageController extends Controller
{
    /**
     * Main view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $events = Event::with('groups')->get();
        return view('home', [
            'events' => $events
        ]);
    }
}
