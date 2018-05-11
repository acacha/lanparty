<?php

namespace Tests\Feature;

use App\Prize;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class WinnersControllerTest.
 *
 * @package Tests\Feature
 */
class WinnersControllerTest extends TestCase
{
    use RefreshDatabase;

    /**@test */
    public function can_see_winners()
    {
        // TODO
        $this->assertTrue(true);
    }

    /** @test */
    public function can_list_winners()
    {
        $response = $this->json('GET','api/v1/winners');
        $response->assertSuccessful();
    }

    /** @test */
    public function can_remove_all_winners()
    {
        seed_database();
        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        //Create some winners
        initialize_prizes();
        $this->assertTrue($count = Prize::all()->count() > 0);

        foreach (Prize::available()->get()->take(5) as $availablePrize) {
            $availablePrize->number()->associate(factory(User::class)->create());
            $availablePrize->save();
        }
        $this->assertEquals(5,Prize::winners()->get()->count());

        $response = $this->json('DELETE','api/v1/winners');
        $response->assertSuccessful();


        $this->assertEquals(5, $response->getContent());
        $this->assertEquals(0,Prize::winners()->get()->count());
        $this->assertEquals($count, Prize::all()->count());


    }

    /** @test */
    public function user_cannot_remove_all_winners()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user,'api');
        $response = $this->json('DELETE','api/v1/winners');
        $response->assertStatus(403);
    }

}
