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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageEventController extends Controller
{
    public function store(ImageStore $request)
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $path = $request->file('image')->storeAs(
            'public/event_images', $request->event_id. '.'. $extension
        );
//        dd($event->image);
        if ( $event=Event::where('id',$request->event_id)->first()) {
            $event->image = $path;
            $event->save();
//            $event->fresh();

        }
        return back();
    }
    public function show(Request $request)
    {
        $event = Event::where('id',$request->id)->first();
        $photo= Storage::disk('local')->exists($event->image) ? $event->image : $this->defaultPhoto();
//        dd(Storage::disk('local')->path($photo));
        return response()->file(Storage::disk('local')->path($photo), [
            'Cache-Control' => 'no-cache, must-revalidate, no-store, max-age=0, private',
            'Pragma' => 'no-cache'
        ]);
    }
    protected function defaultPhoto()
    {
        return Event::DEFAULT_PHOTO_PATH;
    }

}
