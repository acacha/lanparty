<?php

namespace Tests\Feature;

use App\Number;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class MassiveUnassignNumberToUserTest.
 *
 * @package Tests\Feature
 */
class MassiveUnassignNumberToUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_manager_can_unassign_all_numbers_assigned_to_an_user()
    {
        initialize_roles();
        Number::addNumbers(5,config('lanparty.session'));
        $user = factory(User::class)->create();

        Number::firstAvailableNumber(config('lanparty.session'))->assignUser($user);
        Number::firstAvailableNumber(config('lanparty.session'))->assignUser($user);
        Number::firstAvailableNumber(config('lanparty.session'))->assignUser($user);
        Number::firstAvailableNumber(config('lanparty.session'))->assignUser($user);

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/unassign_numbers');
        $response->assertSuccessful();

        $this->assertCount(0,$user->numbers);

    }

    /** @test */
    public function a_not_manager_cannot_unassign_all_numbers_assigned_to_an_user()
    {
        initialize_roles();
        Number::addNumbers(5, config('lanparty.session'));
        $user = factory(User::class)->create();

        Number::firstAvailableNumber(config('lanparty.session'))->assignUser($user);
        Number::firstAvailableNumber(config('lanparty.session'))->assignUser($user);
        Number::firstAvailableNumber(config('lanparty.session'))->assignUser($user);
        Number::firstAvailableNumber(config('lanparty.session'))->assignUser($user);

        $manager = factory(User::class)->create();
        $this->actingAs($manager,'api');

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/unassign_numbers');
        $response->assertStatus(403);

    }
}
