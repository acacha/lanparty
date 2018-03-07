<?php

namespace Tests\Feature;

use App\Event;
use App\Number;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class RegisterToEventTest.
 *
 * @package Tests\Feature
 */
class RegisterToEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function logged_user_can_register_to_an_event()
    {
        $this->withoutExceptionHandling();

        seed_database();

        $participant = factory(User::class)->create();
        $this->actingAs($participant,'api');
        $event = Event::inRandomOrder()->published()->where('inscription_type_id',2)->first();

        $response = $this->json('POST','/api/v1/events/' . $event->id . '/register');

        $response->assertSuccessful();
        $this->assertEquals($event->users()->first()->id, $participant->id);
        $this->assertEquals($participant->events()->first()->id, $event->id);

    }

    /**
     * @test
     */
    public function logged_user_can_unregister_to_an_event()
    {
        $this->withoutExceptionHandling();

        seed_database();

        $participant = factory(User::class)->create();
        $this->actingAs($participant,'api');
        $event = Event::inRandomOrder()->published()->where('inscription_type_id',2)->first();

        $response = $this->json('DELETE','/api/v1/events/' . $event->id . '/register');

        $response->assertSuccessful();
        $this->assertCount(0,$event->users);
        $this->assertCount(0,$participant->events);

    }

    /**
     * @test
     */
    public function logged_user_cannot_register_to_an_event_already_registered()
    {
        seed_database();

        $participant = factory(User::class)->create();
        $this->actingAs($participant,'api');
        $event = Event::inRandomOrder()->published()->where('inscription_type_id',2)->first();
        $event->registerUser($participant);

        $response = $this->json('POST','/api/v1/events/' . $event->id . '/register');

        $response->assertStatus(422);
        $this->assertEquals("L'usuari ja està apuntat al esdeveniment!", json_decode($response->getContent())->message);
        $this->assertEquals($event->users()->first()->id, $participant->id);
        $this->assertEquals($participant->events()->first()->id, $event->id);

    }

    /**
     * @test
     */
    public function logged_user_cannot_register_to_an_event_unpublished()
    {
        seed_database();

        $participant = factory(User::class)->create();
        $this->actingAs($participant,'api');
        $event = Event::inRandomOrder()->unpublished()->where('inscription_type_id',2)->first();

        $response = $this->json('POST','/api/v1/events/' . $event->id . '/register');

        $response->assertStatus(422);
        $this->assertEquals('No es pot es pot registrar un usuari a un esdeveniment sense publicar', json_decode($response->getContent())->message);
        $this->assertCount(0,$event->users);
        $this->assertCount(0,$participant->events);

    }

}
