<?php

namespace App\Http\Controllers\Web;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\Events\ManageEventsIndex;

/**
 * Class EventsController.
 *
 * @package App\Http\Controllers
 */
class EventsController extends Controller
{
    /**
     * @param ManageEventsIndex $request
     * @return mixed
     */
    public function index(ManageEventsIndex $request)
    {
        $events = Event::all_events();
        return view('manage.events.index', compact('events'));
    }
}
