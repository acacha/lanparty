<?php
/**
 * Created by PhpStorm.
 * User: alumne
 * Date: 11/05/19
 * Time: 4:24
 */

namespace App\Http\Controllers\Web;


use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\Events\image\ImageStore;

class ImageEventController extends Controller
{
    public function store(ImageStore $request)
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $path = $request->file('image')->storeAs(
            'public/event_images', $request->event_id. '.'. $extension
        );
        $event = Event::where('id',$request->event_id)->first();
        if ( $event) {
            $event->image = $path;
            $event->save();
        }
        return back();
    }

}
