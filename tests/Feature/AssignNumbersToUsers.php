<?php

namespace Tests\Feature;

use App\Number;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class AssignNumbersToUsers.
 *
 * @package Tests\Feature
 */
class AssignNumbersToUsers extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_number_can_be_assigned_to_a_user()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $numbers = factory(Number::class)->create();

        $response = $this->post('/assign_number');

        $response->assertStatus(201);

        dd($user->numbers);

    }
}
