<?php

namespace App\Http\Controllers\Web;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\Events\EventsIndex;

/**
 * Class ManagersController.
 *
 * @package App\Http\Controllers
 */
class ManagersController extends Controller
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
