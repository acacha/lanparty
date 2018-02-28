<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;

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
    public function index()
    {
        return EventResource::collection(Event::published()->get());
    }
}
