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
    use RefreshDatabase;

    /** @test */
    public function can_register_users()
    {
        seed_database();
        $event = Event::inRandomOrder()->get()->first();

        $user = factory(User::class)->create();
        $event->registerUser($user);

        $this->assertEquals($event->users->first()->id, $user->id);
        $this->assertEquals($user->events->first()->id, $event->id);
    }
}
