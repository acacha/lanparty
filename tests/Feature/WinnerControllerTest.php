<?php

namespace Tests\Feature;

use App\Number;
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
    public function can_add_winner() {
        seed_database();
        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        initialize_prizes();
        $prize = Prize::available()->first();
        $this->assertNull($prize->number);
        $number = Number::available()->first();
        $number->assignUser(factory(User::class)->create());
        $number = Number::assigned()->first();
        $response = $this->json('POST','api/v1/winner/' . $prize->id, [
            'number' => $number->id
        ]);

        $response->assertSuccessful();
        $result = json_decode($response->getContent());

        $this->assertEquals($prize->id, $result->id);
        $this->assertEquals($prize->name, $result->name);

        $this->assertNull(Prize::available()->find($prize->id));
        $prize = $prize->fresh();
        $this->assertTrue($prize->number->is($number));
    }

    /** @test */
    public function user_cannot_add_winner() {
        seed_database();
        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        initialize_prizes();
        $prize = Prize::available()->first();
        $number = Number::available()->first();
        $response = $this->json('POST','api/v1/winner/' . $prize->id, [
            'number_id' => $number->id
        ]);

        $response->assertStatus(403);
    }

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
    public function cannot_remove_a_winner_in_old_sessions()
    {
        create_inscription_types();
        create_events();
        create_numbers();
        create_tickets();
        initialize_roles();
        initialize_partners();
        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        //Create some winners
        initialize_prizes('2018');
        $this->assertTrue($count = Prize::all()->count() > 0);

        foreach ($prizes = Prize::available()->get()->take(5) as $availablePrize) {
            $availablePrize->number()->associate(factory(User::class)->create());
            $availablePrize->save();
        }
        $price = $prizes[0];
        $this->assertEquals(5,Prize::winners()->get()->count());

        $response = $this->json('DELETE','api/v1/winner/' . $price->id);
        $response->assertStatus(422);
        $result = json_decode($response->getContent());
        $this->assertEquals('NO és possible realitzar accions en sessions arxivades.', $result->message);
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
