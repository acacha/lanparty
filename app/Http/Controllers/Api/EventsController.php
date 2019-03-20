<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;

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
