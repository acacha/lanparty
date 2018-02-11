<?php

namespace Tests\Feature;

use App\Event;
use App\Number;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class WelcomePageTest.
 *
 * @package Tests\Feature
 */
class WelcomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function see_welcome_page_for_user_not_logged()
    {
        $response = $this->get('/');

        $response->assertSuccessful();
        $response->assertViewIs('welcome');
        $response->assertViewHas([
            'user' => null
        ]);

    }

    /**
     * @test
     */
    public function see_user_numbers_and_events_info_at_main_page()
    {
//        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        seed_database();

        $events = Event::all();

        $numbers = factory(Number::class, 3)->create();

        foreach ($numbers as $number) {
            $number->assignUser($user);
        }

        $this->actingAs($user);

        $response = $this->get('/main');

        $response->assertSuccessful();
        $response->assertViewIs('main');
        $response->assertViewHas([
            'events' => $events
        ]);

        $response->assertSee($user->email);
        $response->assertSee($user->name);
        $response->assertSee($user->givenName);
        $response->assertSee($user->sn1);
        $response->assertSee($user->sn2);
        $response->assertSee($user->formatted_created_at_date);

        foreach ($events as $event) {
            $response->assertSee($event->name);
        }

        foreach ($numbers as $number) {
            $response->assertSee((String) $number->value);
        }

    }
}
