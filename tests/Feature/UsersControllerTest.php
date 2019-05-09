<?php

namespace Tests\Feature;

use App\Event;
use App\Ticket;
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
        $this->withoutExceptionHandling();
        seed_database();

        $users = factory(User::class,5)->create();

        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->first();
        $event->addTickets(10);
        $paidUser = factory(User::class)->create();
        $paidUser->pay(config('lanparty.session'));

        $this->actingAs($users->first(),'api');
        $response = $this->json('GET','api/v1/users');
        $response->assertSuccessful();
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
        $this->assertTrue(in_array(config('lanparty.session'),$users[5]->inscription_paid));
    }

    /** @test */
    public function manager_can_update_user()
    {
        seed_database();
        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');
        $user = factory(User::class)->create();
        $response = $this->json('PUT','api/v1/users/' . $user->id, [
            'email' => 'pepepardo@jeans.com',
            'name' => 'Pepe Pardo Jeans',
            'givenName' => 'Pepe',
            'sn1' => 'Pardo',
            'sn2' => 'Jeans'
        ]);

        $response->assertSuccessful();
        $user = User::find($user->id);

        $this->assertEquals('Pepe Pardo Jeans',$user->name);
        $this->assertEquals('Pepe',$user->givenName);
        $this->assertEquals('Pardo',$user->sn1);
        $this->assertEquals('Jeans',$user->sn2);
        $this->assertEquals('pepepardo@jeans.com',$user->email);
    }

    /** @test */
    public function users_cannnot_update_other_users()
    {
        seed_database();
        $otherUser = factory(User::class)->create();
        $this->actingAs($otherUser,'api');
        $user = factory(User::class)->create();
        $response = $this->json('PUT','api/v1/users/' . $user->id, [
            'email' => 'pepepardo@jeans.com',
            'name' => 'Pepe Pardo Jeans',
            'givenName' => 'Pepe',
            'sn1' => 'Pardo',
            'sn2' => 'Jeans'
        ]);

        $response->assertStatus(403);

    }
}
