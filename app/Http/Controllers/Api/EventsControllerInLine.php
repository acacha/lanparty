<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\Events\EventsUpdate;

class EventsControllerInLine extends Controller
{
    public function update(EventsUpdate $request, Event $event)
    {
        $event->name = $request->name;
        $event->save();
        return $event->map();
    }
}
