<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ParticipantMessage
 * @package App
 */
class ParticipantMessage extends Model
{
    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function recipients()
    {
        return $this->event->users()->pluck('email');
    }
}
