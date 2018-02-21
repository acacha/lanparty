<?php

namespace App\Http\Controllers;

use App\Event;
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
        return Event::published()->get();
    }
}
