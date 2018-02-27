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
        $participants = $this->message->recipients()->each(function($participant) {
            Mail::to($participant)->send(new ParticipantMessageEmail($this->message));
        });
    }
}
