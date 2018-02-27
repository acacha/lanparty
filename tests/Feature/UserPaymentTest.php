<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class UserPaymentTest.
 *
 * @package Tests\Feature
 */
class UserPaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_manager_user_can_mark_user_as_paid()
    {
        seed_database();

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $user = factory(User::class)->create();

        $this->assertEquals(false,$user->inscription_paid);

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay');

        $response->assertSuccessful();
        $this->assertEquals(true,$user->inscription_paid);
    }

    /** @test */
    public function cannot_pay_two_or_more_times()
    {
//        $this->withoutExceptionHandling();
        seed_database();

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');
        $user = factory(User::class)->create();
        $user->pay();
        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay');
        $response->assertStatus(422);
        $this->assertEquals(true,$user->inscription_paid);
        $this->assertEquals('L\'usuari ja ha pagat la inscripció',json_decode($response->getContent())->message);
    }

    /** @test */
    public function cannot_unpay_a_not_paid_ticket()
    {
//        $this->withoutExceptionHandling();
        seed_database();

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');
        $user = factory(User::class)->create();
        $this->assertEquals(false,$user->inscription_paid);
        $response = $this->json('DELETE','/api/v1/user/' . $user->id . '/pay');
        $this->assertEquals(false,$user->inscription_paid);
        $response->assertStatus(422);
        $this->assertEquals('L\'usuari no ha pagat el ticket',json_decode($response->getContent())->message);
    }

    /** @test */
    public function participants_cannot_mark_user_as_paid()
    {
        seed_database();

        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        $this->assertEquals(false,$user->inscription_paid);

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay');

        $response->assertStatus(403);
        $this->assertEquals(false,$user->inscription_paid);
    }

    /** @test */
    public function a_manager_user_can_mark_user_as_unpaid()
    {
        seed_database();

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $user = factory(User::class)->create();
        $user->pay();
        $this->assertEquals(true,$user->inscription_paid);

        $response = $this->json('DELETE','/api/v1/user/' . $user->id . '/pay');

        $response->assertSuccessful();
        $this->assertEquals(false,$user->inscription_paid);
    }

    /** @test */
    public function participants_cannot_mark_user_as_unpaid()
    {
        seed_database();

        $user = factory(User::class)->create();
        $this->actingAs($user,'api');
        $user->pay();
        $this->assertEquals(true,$user->inscription_paid);

        $response = $this->json('DELETE','/api/v1/user/' . $user->id . '/pay');

        $response->assertStatus(403);
        $this->assertEquals(true,$user->inscription_paid);
    }
}
