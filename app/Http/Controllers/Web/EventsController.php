<?php

namespace App\Http\Controllers\Web;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\Events\EventsIndex;

/**
 * Class EventsController.
 *
 * @package App\Http\Controllers
 */
class EventsController extends Controller
{
    /**
     * @return mixed
     */
    public function index(EventsIndex $request)
    {
        $events = Event::events();
        return view('manage.events.index', compact('events'));
    }
}
