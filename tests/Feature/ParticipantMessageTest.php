<?php

namespace Tests\Feature;

use App\Event;
use App\Jobs\SendParticipantMessage;
use App\ParticipantMessage;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Queue;
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
    function a_manager_can_send_a_new_message()
    {
        $this->withoutExceptionHandling();

        Queue::fake();

        $user = factory(User::class)->create();
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => 1,
            'image' => 'img/LoL.jpeg',
            'regulation' => 'http://example.com/regulation'
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

//        Queue::assertPushed(SendParticipantMessage::class);
        Queue::assertPushed(SendParticipantMessage::class, function ($job) use ($message) {
//            return $job->message->id === $message->id;
            return $job->message->is($message);
        });
    }

    function subject_is_required()
    {
        Queue::fake();
        $user = factory(User::class)->create();
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => 1,
            'image' => 'img/LoL.jpeg',
        ]);

        $this->actingAs($user);
        $response = $this->post("/manage/events/{$event->id}/messages", [
            'subject' => '',
            'message' => 'My message',
        ]);

        $response->assertRedirect("/manage/events/{$event->id}/messages");

        $response->assertSessionHasErrors('subject');
        $this->assertEquals(0, ParticipantMessage::count());
        Queue::assertNotPushed(SendParticipantMessage::class);
    }

    function message_is_required()
    {
        Queue::fake();
        $user = factory(User::class)->create();
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => 1,
            'image' => 'img/LoL.jpeg',
        ]);

        $this->actingAs($user);
        $response = $this->post("/manage/events/{$event->id}/messages", [
            'subject' => 'My Subject',
            'message' => '',
        ]);

        $response->assertRedirect("/manage/events/{$event->id}/messages");

        $response->assertSessionHasErrors('message');
        $this->assertEquals(0, ParticipantMessage::count());
        Queue::assertNotPushed(SendParticipantMessage::class);
    }

}
