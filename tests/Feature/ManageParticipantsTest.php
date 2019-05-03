<?php

namespace Tests\Feature;

use App\Event;
use App\Number;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ManageParticipantsTest.
 *
 * @package Tests\Feature
 */
class ManageParticipantsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function see_users_and_numbers_in_manage_participants_page()
    {
        $this->withoutExceptionHandling();
        seed_database();
        initialize_roles();

        $users = factory(User::class,5)->create();

        foreach ( range(1,10) as $i) {
            Number::firstAvailableNumber(config('lanparty.session'))->assignUser($users->random());
        }

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager);

        $response = $this->get('/manage/participants');

        $response->assertSuccessful();
        $response->assertViewIs('manage.participants');
        $response->assertViewHas('users', function ($viewUsers) use ($users) {
            if ($users->pluck('id')->diff($viewUsers->pluck('id'))->count() != 0) return false;
            return true;
        });

        $events = Event::published();
        $response->assertViewHas('events', function ($viewEvents) use ($events) {
            if ($events->pluck('id')->diff($viewEvents->pluck('id'))->count() != 0) return false;
            return true;
        });

        $numbers = Number::available()->get();
        $response->assertViewHas('numbers', function ($viewNumbers) use ($numbers) {
            if ($numbers->pluck('id')->diff($viewNumbers->pluck('id'))->count() != 0) return false;
            return true;
        });

    }

    /**
     * @test
     */
    public function cannot_manage_participants_if_not_manager()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->get('/manage/participants');

        $response->assertStatus(403);


    }


}
