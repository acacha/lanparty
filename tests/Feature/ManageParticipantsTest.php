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
//        $this->withoutExceptionHandling();

        seed_database();
        initialize_roles();

        $users = factory(User::class,5)->create();
        $numbers = factory(Number::class,10)->create();
        foreach ($numbers as $number) {
            $number->assignUser($users->random());
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

        $response->assertViewHas('numbers', function ($viewNumbers) use ($numbers) {
            if ($numbers->pluck('id')->diff($viewNumbers->pluck('id'))->count() != 0) return false;
            return true;
        });

    }
}
