<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class ParticipantMessageEmail.
 *
 * @package App\Mail
 */
class ParticipantMessageEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    /**
     * ParticipantMessageEmail constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.participantmessage');
    }
}
