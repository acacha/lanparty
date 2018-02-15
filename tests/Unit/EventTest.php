<?php

namespace Tests\Unit;

use App\Event;
use App\Exceptions\InscriptionException;
use App\Group;
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
        seed_database();
        $this->event = Event::inRandomOrder()->where('inscription_type_id',2)->get()->first();
        $this->user = factory(User::class)->create();
        $this->event->inscribeUser($this->user);

        $this->assertEquals($this->event->users->first()->id, $this->user->id);
        $this->assertEquals($this->user->events->first()->id, $this->event->id);
    }

    /** @test */
    public function cannot_register_users_to_events_of_type_groupal()
    {
        seed_database();
        $this->event = Event::inRandomOrder()->where('inscription_type_id',1)->first();
        $this->user = factory(User::class)->create();
        try {
            $this->event->inscribeUser($this->user);
        } catch (InscriptionException $exception) {
            $this->assertEquals(count($this->event->users), 0);
            $this->assertEquals(count($this->user->events), 0);
            return;
        }

        $this->fail('An user cannot be assigned to an event of type groupal');
    }

    /** @test */
    public function can_register_groups()
    {
        seed_database();
        $this->event = Event::inRandomOrder()->where('inscription_type_id',1)->first();
        $group = factory(Group::class)->create();
        $this->event->inscribeGroup($group);

        $this->assertEquals($this->event->groups->first()->id, $group->id);
        $this->assertEquals($group->events->first()->id, $this->event->id);
    }

    /** @test */
    function can_determine_if_logged_user_is_subscribed_to_event()
    {
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
        seed_database();
        $this->event = Event::inRandomOrder()->where('inscription_type_id',2)->first();
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
