<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\Events\EventsDestroy;
use App\Http\Requests\Events\EventsIndex;
use App\Http\Requests\Events\EventsShow;
use App\Http\Requests\Events\EventsStore;
use App\Http\Requests\Events\EventsUpdate;
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
    public function index(EventsIndex $request)
    {
        return EventResource::collection(Event::published()->get());
    }

    public function store(EventsStore $request)
    {
        $event=new Event();
        $event->name=$request->name;
        $event->inscription_type_id=$request->inscription_type_id;
        $event->image=$request->image;
        $event->regulation=$request->regulation;
        $event->save();
        return $event->map();

    }

    public function destroy(EventsDestroy $request,Event $event)
    {
        $event->delete();
        return $event;

    }

    public function update(EventsUpdate $request,Event $event)
    {
        $event->name=$request->name;
        $event->inscription_type_id=$request->inscription_type_id;
        $event->image=$request->image;
        $event->regulation=$request->regulation;
        $event->save();
        return $event->map();

    }

    public function show(EventsShow $request,Event $event)
    {
        return $event->map();

    }
}
