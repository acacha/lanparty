<?php

namespace Tests\Feature;

use App\Prize;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class WinnerControllerTest.
 *
 * @package Tests\Feature
 */
class WinnerControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_remove_a_winner()
    {
        seed_database();
        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        //Create some winners
        initialize_prizes();
        $this->assertTrue($count = Prize::all()->count() > 0);

        foreach ($prizes = Prize::available()->get()->take(5) as $availablePrize) {
            $availablePrize->number()->associate(factory(User::class)->create());
            $availablePrize->save();
        }
        $price = $prizes[0];
        $this->assertEquals(5,Prize::winners()->get()->count());

        $response = $this->json('DELETE','api/v1/winner/' . $price->id);
        $response->assertSuccessful();
        $result = json_decode($response->getContent());

        $this->assertEquals($price->name, $result->name);
        $this->assertNull($result->number);
        $this->assertNull($result->number_id);
        $this->assertEquals(4,Prize::winners()->get()->count());
        $this->assertNull(Prize::find($price->id)->number_id);
        $this->assertEquals($count, Prize::all()->count());
    }

    /** @test */
    public function user_cannot_remove_a_winner()
    {
        seed_database();
        $user = factory(User::class)->create();
        $this->actingAs($user,'api');
        initialize_prizes();
        $availablePrize = Prize::available()->first();
        $availablePrize->number()->associate(factory(User::class)->create());
        $availablePrize->save();
        $response = $this->json('DELETE','api/v1/winner/' . $availablePrize->id);
        $response->assertStatus(403);
    }
}
