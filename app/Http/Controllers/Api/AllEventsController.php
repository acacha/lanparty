<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\Events\AllEventsIndex;

/**
 * Class AllEventsController.
 *
 * @package App\Http\Controllers
 */
class AllEventsController extends Controller
{
    public function index(AllEventsIndex $request)
    {
        return Event::all_events();
    }
}
