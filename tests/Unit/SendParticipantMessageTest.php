<?php

namespace Tests\Unit;

use App\Jobs\SendParticipantMessage;
use App\Mail\ParticipantMessageEmail;
use App\ParticipantMessage;
use App\Event;
use App\User;
use Carbon\Carbon;
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

        $user1 = User::create([
            'name' => 'Pepito',
            'email' => 'pepito@gmail.com'
        ]);
        $user2 = User::create([
            'name' => 'Maria',
            'email' => 'maria@gmail.com'
        ]);
        $user3 = User::create([
            'name' => 'Xavi',
            'email' => 'xavi@gmail.com'
        ]);

        // Preparació
        $event = Event::create([
            'name' => 'FIFA 18',
            'inscription_type_id' => 2,
            'image' => 'img/Fifa18.jpeg',
            'regulation' => 'regulation_here',
            'published_at' => Carbon::now()->subDays(30)
        ]);
        $event->addTickets(10);
        $event->registerUser($user1);
        $event->registerUser($user2);
        $event->registerUser($user3);

        $message = ParticipantMessage::create([
            'subject' => 'Prova subject',
            'message' => 'Prova missatge',
            'event_id' => $event->id
        ]);

        //Execució
//        $job = new SendParticipantMessage();
//        $job->handle();
        SendParticipantMessage::dispatch($message);

        // Si preparem per a 3 persones apuntades he de comprovar que s'envien 3 emails

        Mail::assertSent(ParticipantMessageEmail::class, function ($mail) use ($message) {
            return $mail->hasTo('pepito@gmail.com') && $mail->message->is($message);
        });

        Mail::assertSent(ParticipantMessageEmail::class, function ($mail) use ($message) {
            return $mail->hasTo('maria@gmail.com') && $mail->message->is($message);
        });

        Mail::assertSent(ParticipantMessageEmail::class, function ($mail) use ($message) {
            return $mail->hasTo('javi@gmail.com') && $mail->message->is($message);
        });

    }
}
