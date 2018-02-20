<?php

namespace Tests\Feature;

use App\Event;
use App\ParticipantMessage;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ParticipantMessageTest.
 *
 * @package Tests\Feature
 */
class ParticipantMessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_promoter_can_send_a_new_message()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => 1,
            'image' => 'img/LoL.jpeg',
        ]);

        $this->actingAs($user);
        $response = $this->post("/manage/events/{$event->id}/messages", [
            'subject' => 'My subject',
            'message' => 'My message',
        ]);

        $message = ParticipantMessage::first();

        $this->assertEquals('My subject', $message->subject);
        $this->assertEquals('My message', $message->message);
        $this->assertEquals($event->id, $message->event_id);

        $response->assertRedirect("/manage/events/{$event->id}/messages");
        $response->assertSessionHas('flash','Your message has been sent!');
    }
}
