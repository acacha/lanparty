<?php

namespace App\Jobs;

use App\Mail\ParticipantMessageEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

/**
 * Class SendParticipantMessage
 * @package App\Jobs
 */
class SendParticipantMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $message;

    /**
     * SendParticipantMessage constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->message->recipients()->chunk(20)->each(function($recipient) {
            Mail::to($recipient)->send(new ParticipantMessageEmail($this->message));
        });

//        $this->message->withChunckedRecipients( function ($recipients) {
//            $recipients->each( function($recipient) {
//                Mail::to($recipient)->send(new ParticipantMessageEmail($this->message));
//            });
//        });
    }
}
