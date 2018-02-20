<?php

namespace App\Http\Controllers;

use App\Event;
use App\Jobs\SendParticipantMessage;
use App\ParticipantMessage;
use Illuminate\Http\Request;

/**
 * Class ParticipantMessagesController.
 *
 * @package App\Http\Controllers
 */
class ParticipantMessagesController extends Controller
{
    /**
     * @return string
     */
    public function store(Request $request, Event $event)
    {
        $this->validate(request(), [
            'subject' => ['required'],
            'message' => ['required'],
        ]);

        $message = ParticipantMessage::create([
            'subject' => $request->subject,
            'message' => $request->message,
            'event_id' => $event->id
        ]);

        SendParticipantMessage::dispatch($message);

        return redirect()->route('manage.event-messages.store',$event->id)
            ->with('flash','Your message has been sent!');
    }
}
