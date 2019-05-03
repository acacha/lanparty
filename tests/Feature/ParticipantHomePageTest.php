<?php

namespace Tests\Feature;

use App\Event;
use App\Number;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ParticipantHomePageTest.
 *
 * @package Tests\Feature
 */
class ParticipantHomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function see_user_numbers_and_events_info_at_home_page()
    {
        $users = factory(User::class,5)->create();
        $user = $users->first();

        seed_database();

        $events = Event::published();

        foreach ( range (1,3) as $i) {
            Number::firstAvailableNumber(config('lanparty.session'))->assignUser($user);
        }

        $this->actingAs($user);

        $response = $this->get('/home');

        $response->assertSuccessful();
        $response->assertViewIs('home');

        $response->assertViewHas('events', function ($viewEvents) use ($events) {
            if ($events->pluck('id')->diff($viewEvents->pluck('id'))->count() != 0) return false;
            return true;
        });

        $response->assertViewHas('users', function ($viewUsers) use ($users) {
            if ($users->pluck('id')->diff($viewUsers->pluck('id'))->count() != 0) return false;
            return true;
        });

        foreach ($events as $event) {
            $response->assertSee($event->name);
        }

        foreach ($user->numbers as $number) {
            $response->assertSee((String) $number->value);
        }

    }
}
