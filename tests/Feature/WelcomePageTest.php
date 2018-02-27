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
    }

    /**
     * @test
     */
    public function see_welcome_page_for_user_logged()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertSuccessful();
        $response->assertViewIs('welcome');
    }

}
