<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\Events\EventsDestroy;
use App\Http\Requests\Events\EventsIndex;
use App\Http\Requests\Events\EventsShow;
use App\Http\Requests\Events\EventsStore;
use App\Http\Requests\Events\EventsUpdate;

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
        return Event::published_events();
    }

    public function store(EventsStore $request)
    {

        $event=new Event();
        $event->name=$request->name;
        $event->inscription_type_id=$request->inscription_type_id;
        $event->image=$request->image;
        $event->regulation=$request->regulation;
        $event->session=$request->session;
        $event->save();
//        dd("request ".$request);
        return $event->map();

    }

    public function destroy(EventsDestroy $request,Event $event)
    {
        $event->forceDelete();
        return $event;

    }

    public function update(EventsUpdate $request,Event $event)
    {
        $event->name=$request->name;
        $event->inscription_type_id=$request->inscription_type_id;
        $event->image=$request->image;
        $event->regulation=$request->regulation;
        $event->session=$request->session;
        $event->save();
        return $event->map();

    }

    public function show(EventsShow $request,Event $event)
    {
        return $event->map();

    }
}
