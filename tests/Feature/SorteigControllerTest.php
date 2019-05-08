<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class SorteigControllerTest.
 *
 * @package Tests\Feature
 */
class SorteigControllerTest extends TestCase
{
    use RefreshDatabase;

    /**  @test */
    public function manager_can_see_sorteig()
    {
        initialize_roles();
        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager);

        $response= $this->get('/manage/sorteig');

        $response->assertSuccessful();
        $response->assertViewIs('manage.sorteig');
        $response->assertViewHas('numbers');
        $response->assertViewHas('prizes');
        $response->assertViewHas('winners');
    }

    /**  @test */
    public function user_cannot_see_sorteig()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response= $this->get('/manage/sorteig');

        $response->assertStatus(403);
    }
}
