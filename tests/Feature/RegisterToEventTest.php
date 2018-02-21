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
//        $this->withoutExceptionHandling();

        seed_database();

        $participant = factory(User::class)->create();
        $this->actingAs($participant,'api');
        $event = Event::inRandomOrder()->where('inscription_type_id',2)->first();

        $response = $this->post('/api/v1/events/' . $event->id . '/register');

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
        $event = Event::inRandomOrder()->where('inscription_type_id',2)->first();

        $response = $this->delete('/api/v1/events/' . $event->id . '/register');

        $response->assertSuccessful();
        $this->assertCount(0,$event->users);
        $this->assertCount(0,$participant->events);

    }
}
