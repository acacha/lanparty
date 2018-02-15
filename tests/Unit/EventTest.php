<?php

namespace Tests\Unit;

use App\Event;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class EventTest.
 *
 * @package Tests\Unit
 */
class EventTest extends TestCase
{
    protected $event;

    protected $user;

    use RefreshDatabase;

    /** @test */
    public function can_register_users()
    {
        $this->randomEvent();
        $this->user = factory(User::class)->create();
        $this->event->inscribeUser($this->user);

        $this->assertEquals($this->event->users->first()->id, $this->user->id);
        $this->assertEquals($this->user->events->first()->id, $this->event->id);
    }

    /** @test */
    function can_determine_if_logged_user_is_subscribed_to_event()
    {
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
        $this->randomEvent();
        $this->event->inscribeUser($this->user);

        $this->assertTrue($this->event->inscribed);
    }

    /** @test */
    function can_determine_if_logged_user_is_no_subscribed_to_event()
    {
        $this->randomEvent();
        $this->assertFalse($this->event->inscribed);
    }

    protected function randomEvent() {
        seed_database();
        $this->event = Event::inRandomOrder()->get()->first();
    }
}
