<?php

namespace Tests\Feature;

use App\Event;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class UsersControllerTest
 * @package Tests\Feature
 */
class UsersControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_retrieve_all_users()
    {
        seed_database();

        $users = factory(User::class,5)->create();

        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->first();
        $event->addTickets(10);
        $paidUser = factory(User::class)->create();
        $paidUser->pay();

        $this->actingAs($users->first(),'api');
        $response = $this->json('GET','api/v1/users');
        $response->assertSuccessful();
//        $response->dump();
        $this->assertCount(6,json_decode($response->getContent()));
        $response->assertJsonStructure([[
                'id',
                'name',
                'email',
                'givenName',
                'sn1',
                'sn2',
                'formatted_created_at_date',
                'full_search',
                'numbers',
                'inscription_paid',
                'events'
        ]]);

        // Check paid user

        $users = json_decode($response->getContent());
        $this->assertTrue($users[5]->inscription_paid);
    }
}
