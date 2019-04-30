<?php

namespace Tests\Feature\Api;

use App\Ticket;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class TicketsControllerTest.
 *
 * @package Tests\Feature
 */
class TicketsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function logged_user_can_fetch_tickets()
    {
        $tickets = factory(Ticket::class, 5)->create(
            ['session' => '2018']
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
}
