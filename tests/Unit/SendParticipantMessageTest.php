<?php

namespace Tests\Unit;

use App\Jobs\SendParticipantMessage;
use App\Mail\ParticipantMessageEmail;
use App\ParticipantMessage;
use App\Event;
use Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class SendParticipantMessageTest.
 *
 * @package Tests\Unit
 */
class SendParticipantMessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_the_message_to_all_event_particpants()
    {
        Mail::fake();

        // Preparació
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => 1,
            'image' => 'img/LoL.jpeg',
        ]);

        $message = ParticipantMessage::create([
            'subject' => 'Prova emai',
            'message' => 'Prova missatge',
            'event_id' => $event->id
        ]);

        //Execució

//        $job = new SendParticipantMessage();
//        $job->handle();

        SendParticipantMessage::dispatch($message);

        // Asserts
//        Mail::assertSent(ParticipantMessageEmail::class);
        Mail::assertSent(ParticipantMessageEmail::class, function ($mail) use ($message) {
            return $mail->message->is($message);
        });
    }
}
