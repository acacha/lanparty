<?php

namespace Tests\Feature\Api;

use App\Ticket;
use App\User;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class TicketsControllerTest.
 *
 * @package Tests\Feature
 */
class TicketsControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /** @test */
    public function logged_user_can_fetch_tickets()
    {
        $tickets = factory(Ticket::class, 5)->create(
            ['session' => config('lanparty.session')]
        );

        $user = factory(User::class)->create([
            'name' => 'Acacha',
            'givenName' => 'Sergi',
            'sn1' => 'Tur',
            'sn2' => 'Badenas',
        ]);
        $tickets[0]->assignUser($user);
        $this->actingAs($user,'api');
        $response = $this->json('GET','/api/v1/tickets');
        $response->assertSuccessful();
        $this->assertCount(5,json_decode($response->getContent()));
        $response->assertJsonStructure([[
            'id',
            'user_id',
            'session',
            'user_name',
            'user_email',
            'user_sn1',
            'user_sn2',
            'user_givenName',
            'created_at',
            'updated_at',
        ]]);
        $tickets = json_decode($response->getContent());

        $this->assertEquals('Tur',$tickets[0]->user_sn1);
        $this->assertEquals('Badenas',$tickets[0]->user_sn2);
        $this->assertEquals('Sergi',$tickets[0]->user_givenName);
    }

    /** @test */
    public function manager_can_add_tickets()
    {
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/tickets', [
            'session' => $session = config('lanparty.session'),
            'quantity' => 3
        ]);
        $response->assertSuccessful();
        $this->assertCount(3, $tickets = Ticket::tickets());
        $this->assertEquals($session,$tickets[0]['session']);
        $this->assertNull($tickets[0]['user_id']);
        $this->assertEquals($session,$tickets[1]['session']);
        $this->assertNull($tickets[1]['user_id']);
        $this->assertEquals($session,$tickets[2]['session']);
        $this->assertNull($tickets[2]['user_id']);

    }

    /** @test */
    public function cannot_add_zero_tickets()
    {
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/tickets', [
            'session' => config('lanparty.session'),
            'quantity' => 0
        ]);
        $response->assertStatus(422);
    }

    /** @test */
    public function manager_can_add_tickets_validation()
    {
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/tickets', []);
        $response->assertStatus(422);
    }

    /** @test */
    public function regular_user_cannot_add_tickets()
    {
        $this->login('api');
        $response = $this->json('POST','/api/v1/tickets', [
            'session' => config('lanparty.session'),
            'quantity' => 3
        ]);
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_user_cannot_add_tickets()
    {
        $response = $this->json('POST','/api/v1/tickets', [
            'session' => config('lanparty.session'),
            'quantity' => 3
        ]);
        $response->assertStatus(401);
    }

    /** @test */
    public function manager_can_remove_tickets()
    {
        Ticket::addTickets(4,config('lanparty.session'));
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/tickets/remove', [
            'session' => config('lanparty.session'),
            'quantity' => 3
        ]);
        $response->assertSuccessful();
        $this->assertCount(1, $tickets = Ticket::tickets());
        $this->assertEquals(config('lanparty.session'),$tickets[0]['session']);
        $this->assertNull($tickets[0]['user_id']);
    }

    /** @test */
    function manager_cannot_remove_more_tickets_than_available()
    {
        Ticket::addTickets(3,config('lanparty.session'));
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/tickets/remove', [
            'session' => config('lanparty.session'),
            'quantity' => 4
        ]);
        $response->assertStatus(422);
        $result = json_decode($response->getContent());
        $this->assertEquals('S\'han eliminat tots els tickets disponibles', $result->message);
        $this->assertCount(0, $tickets = Ticket::tickets());
    }

    /** @test */
    public function manager_can_remove_tickets_validation()
    {
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/tickets/remove', []);
        $response->assertStatus(422);
    }

    /** @test */
    public function nobody_can_perform_actions_on_deleted_sessions() {
        Ticket::addTickets(4,'2018');
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/tickets/remove', [
            'session' => '2018',
            'quantity' => 3
        ]);
        $response->assertStatus(422);
        $this->assertEquals('NO és possible realitzar accions en sessions arxivades.',json_decode($response->getContent())->message);

        $this->loginAsSuperAdmin('api');
        $response = $this->json('POST','/api/v1/tickets/remove', [
            'session' => '2018',
            'quantity' => 3
        ]);
        $response->assertStatus(422);
        $this->assertEquals('NO és possible realitzar accions en sessions arxivades.',json_decode($response->getContent())->message);

        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/tickets', [
            'session' => $session = '2018',
            'quantity' => 3
        ]);
        $response->assertStatus(422);
        $this->assertEquals('NO és possible realitzar accions en sessions arxivades.',json_decode($response->getContent())->message);

        $this->loginAsSuperAdmin('api');
        $response = $this->json('POST','/api/v1/tickets', [
            'session' => $session = '2018',
            'quantity' => 3
        ]);
        $response->assertStatus(422);
        $this->assertEquals('NO és possible realitzar accions en sessions arxivades.',json_decode($response->getContent())->message);

    }
}
