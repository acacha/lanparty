<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Resources\EventResourceForHomePage;
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
        $events = EventResourceForHomePage::collection(Event::published()->with(['users','groups.members'])->get());
        return view('home', [
//            'events' => $events,
            'events' => $events->collection,
            'numbers' => collect([]),
            'user' => Auth::user()
        ]);
    }
}
