<?php

namespace Tests\Feature;

use App\Ticket;
use App\User;
use Tests\TestCase;
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

        $this->assertCount(0,$user->inscription_paid);

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay',[
            'session' => 2018
        ]);

        $response->assertSuccessful();
        $this->assertEquals(true,$user->inscription_paid['2018']);
    }

    /** @test */
    public function a_manager_user_cannot_mark_user_as_paid_if_no_more_tickets_available()
    {
        initialize_roles();

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $user = factory(User::class)->create();

        $this->assertCount(0,$user->inscription_paid);

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay',[
            'session' => 2018
        ]);

        $response->assertStatus(422);
        $this->assertEquals("No hi ha més places/tickets disponibles", json_decode($response->getContent())->message);
        $this->assertCount(0,$user->inscription_paid);
    }

    /** @test */
    public function a_manager_user_can_mark_user_as_paid_validation()
    {
        seed_database();

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $user = factory(User::class)->create();

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay');

        $response->assertStatus(422);
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
        $user->pay('2018');
        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay',[
            'session' => 2018
        ]);
        $response->assertStatus(422);
        $this->assertEquals(true,$user->inscription_paid['2018']);
        $this->assertEquals('L\'usuari ja ha pagat la inscripció',json_decode($response->getContent())->message);
    }

    /** @test */
    public function cannot_unpay_a_not_paid_ticket()
    {
        seed_database();

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');
        $user = factory(User::class)->create();
        $this->assertCount(0, $user->inscription_paid);
        $response = $this->json('POST','/api/v1/user/' . $user->id . '/unpay',[
            'session' => 2018
        ]);
        $this->assertCount( 0, $user->inscription_paid);
        $response->assertStatus(422);
        $this->assertEquals('L\'usuari no ha pagat el ticket',json_decode($response->getContent())->message);
    }

    /** @test */
    public function participants_cannot_mark_user_as_paid()
    {
        seed_database();

        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        $this->assertCount(0,$user->inscription_paid);

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay');

        $response->assertStatus(403);
        $this->assertCount(0,$user->inscription_paid);
    }

    /** @test */
    public function a_manager_user_can_mark_user_as_unpaid()
    {
        seed_database();

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $user = factory(User::class)->create();
        $user->pay('2018');
        $this->assertEquals(true,$user->inscription_paid['2018']);

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/unpay',[
            'session' => 2018
        ]);

        $response->assertSuccessful();
        $this->assertCount(0, $user->inscription_paid);
    }

    /** @test */
    public function participants_cannot_mark_user_as_unpaid()
    {
        seed_database();

        $user = factory(User::class)->create();
        $this->actingAs($user,'api');
        $user->pay('2018');
        $this->assertEquals(true,$user->inscription_paid['2018']);

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/unpay',[
            'session' => 2018
        ]);

        $response->assertStatus(403);
        $this->assertEquals(true,$user->inscription_paid['2018']);
    }

    /** @test */
    public function a_manager_user_can_mark_user_as_paid_in_2_sessions()
    {
        seed_database();
        Ticket::addTickets(1,'2019');

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $user = factory(User::class)->create();

        $this->assertCount(0,$user->inscription_paid);

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay',[
            'session' => 2018
        ]);

        $response->assertSuccessful();
        $this->assertEquals(true,$user->inscription_paid['2018']);

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay', [
            'session' => 2019
        ]);

        $response->assertSuccessful();
        $this->assertEquals(true,$user->inscription_paid['2019']);
    }
}
