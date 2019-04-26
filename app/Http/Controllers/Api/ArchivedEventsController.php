<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\Events\ArchivedEventsDestroy;
use App\Http\Requests\Events\ArchivedEventsStore;

/**
 * Class ArchivedEventsController.
 *
 * @package App\Http\Controllers
 */
class ArchivedEventsController extends Controller
{
    public function store(ArchivedEventsStore $request, Event $event)
    {
        $event->delete();
        return $event;
    }

    public function destroy(ArchivedEventsDestroy $request, Event $event)
    {
        $event->restore();
        return $event;
    }

}
