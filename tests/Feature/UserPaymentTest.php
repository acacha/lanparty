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

        $this->assertFalse(in_array(config('lanparty.session'),$user->inscription_paid));

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay',[
            'session' => config('lanparty.session')
        ]);
        $response->assertSuccessful();
        $user = $user->fresh();
        $this->assertTrue(in_array(config('lanparty.session'),$user->inscription_paid));
    }

    /** @test */
    public function a_manager_user_cannot_mark_user_as_paid_if_no_more_tickets_available()
    {
        initialize_roles();

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $user = factory(User::class)->create();

        $this->assertFalse(in_array(config('lanparty.session'),$user->inscription_paid));

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay',[
            'session' => config('lanparty.session')
        ]);

        $response->assertStatus(422);
        $this->assertEquals("No hi ha més places/tickets disponibles", json_decode($response->getContent())->message);
        $this->assertFalse(in_array(config('lanparty.session'),$user->inscription_paid));
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
        seed_database();

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');
        $user = factory(User::class)->create();
        $user->pay(config('lanparty.session'));
        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay',[
            'session' => config('lanparty.session')
        ]);
        $response->assertStatus(422);
        $this->assertTrue(in_array(config('lanparty.session'),$user->inscription_paid));
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
        $this->assertFalse(in_array(config('lanparty.session'),$user->inscription_paid));
        $response = $this->json('POST','/api/v1/user/' . $user->id . '/unpay',[
            'session' => config('lanparty.session')
        ]);
        $this->assertFalse(in_array(config('lanparty.session'),$user->inscription_paid));
        $response->assertStatus(422);
        $this->assertEquals('L\'usuari no ha pagat el ticket',json_decode($response->getContent())->message);
    }

    /** @test */
    public function participants_cannot_mark_user_as_paid()
    {
        seed_database();

        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        $this->assertFalse(in_array(config('lanparty.session'),$user->inscription_paid));

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay');

        $response->assertStatus(403);
        $this->assertFalse(in_array(config('lanparty.session'),$user->inscription_paid));
    }

    /** @test */
    public function a_manager_user_can_mark_user_as_unpaid()
    {
        $this->withoutExceptionHandling();
        seed_database();

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $user = factory(User::class)->create();
        $user->pay(config('lanparty.session'));
        $this->assertTrue(in_array(config('lanparty.session'),$user->inscription_paid));

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/unpay',[
            'session' => config('lanparty.session')
        ]);

        $response->assertSuccessful();
        $user = $user->fresh();
        $this->assertFalse(in_array(config('lanparty.session'),$user->inscription_paid));
    }

    /** @test */
    public function participants_cannot_mark_user_as_unpaid()
    {
        seed_database();

        $user = factory(User::class)->create();
        $this->actingAs($user,'api');
        $user->pay(config('lanparty.session'));
        $this->assertTrue(in_array(config('lanparty.session'),$user->inscription_paid));

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/unpay',[
            'session' => config('lanparty.session')
        ]);

        $response->assertStatus(403);
        $this->assertTrue(in_array(config('lanparty.session'),$user->inscription_paid));
    }

    /** @test */
    public function no_body_can_perform_actions_on_archived_sessions()
    {
        seed_database();

        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $user = factory(User::class)->create();

        $this->assertFalse(in_array(config('lanparty.session'),$user->inscription_paid));

        $response = $this->json('POST','/api/v1/user/' . $user->id . '/pay',[
            'session' => '2018'
        ]);
        $response->assertStatus(422);
        $this->assertEquals('NO és possible realitzar accions en sessions arxivades.',json_decode($response->getContent())->message);


    }
}
