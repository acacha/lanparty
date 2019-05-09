<?php

namespace Tests\Unit;

use App\Event;
use App\Exceptions\InscriptionException;
use App\Exceptions\NotEnoughTicketsException;
use App\Exceptions\UserAlreadyInscribedException;
use App\Group;
use App\InscriptionType;
use App\Role;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class UserTest.
 *
 * @package Tests\Unit
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function map()
    {
        $user = User::create([
            'name' => 'Pepe',
            'email' => 'pepepardo@jeans.com',
            'sn1' => 'Pardo',
            'sn2' => 'Jeans',
            'givenName' => 'Pepe'
        ]);
        $mappedUser = $user->map();
        $this->assertEquals($mappedUser['id'],1);
        $this->assertEquals($mappedUser['name'],'Pepe');
        $this->assertEquals($mappedUser['email'],'pepepardo@jeans.com');
        $this->assertEquals($mappedUser['givenName'],'Pepe');
        $this->assertEquals($mappedUser['sn1'],'Pardo');
        $this->assertEquals($mappedUser['sn2'],'Jeans');
        $this->assertEquals($mappedUser['admin'],false);
        $this->assertEquals($mappedUser['manager'],false);
        $this->assertNotNull($mappedUser['created_at']);
        $this->assertNotNull($mappedUser['updated_at']);
    }

    /** @test */
    public function isManager()
    {
        $user = User::create([
            'name' => 'Pepe',
            'email' => 'pepepardo@jeans.com',
            'sn1' => 'Pardo',
            'sn2' => 'Jeans',
            'givenName' => 'Pepe'
        ]);
        $this->assertFalse($user->isManager());
        $user->assignRole(Role::create([
            'name' => 'Manager'
        ]));
        $user=$user->fresh();
        $this->assertTrue($user->isManager());
    }

    /** @test */
    function can_get_formatted_created_at_date()
    {
        $user = factory(User::class)->make([
            'created_at' => Carbon::parse('2016-12-01 8:00pm'),
        ]);

        $this->assertEquals('08:00:00PM 01-12-2016', $user->formatted_created_at_date);
    }

    /** @test */
    function can_get_full_search_attribute()
    {
        $user = factory(User::class)->create([
            'name' => 'Sergi Tur Badenas',
            'email' => 'sergiturbadenas@gmail.com',
            'givenName' => 'Pepe',
            'sn1' => 'Pardo',
            'sn2' => 'Jeans',
            'created_at' => Carbon::parse('2016-12-01 8:00pm'),
        ]);

        $this->assertEquals('Sergi Tur Badenas sergiturbadenas@gmail.com Pepe Pardo Jeans 08:00:00PM 01-12-2016 1', $user->full_search);
    }

    /** @test */
    function user_can_pay()
    {
        seed_database();
        $user = factory(User::class)->create();
        $this->assertDatabaseMissing('tickets', [
            'user_id' => $user->id
        ]);
        $this->assertFalse(in_array(config('lanparty.session'),$user->inscription_paid));
        $user->pay(config('lanparty.session'));
        $user->fresh();
        $this->assertDatabaseHas('tickets', [
            'user_id' => $user->id
        ]);
        $this->assertCount(1, Ticket::where('user_id', $user->id)->get());
        $user = $user->fresh();
        $this->assertTrue(in_array(config('lanparty.session'),$user->inscription_paid));
    }

    /** @test */
    function user_cannot_pay_if_no_more_ticket_are_available()
    {
        $user = factory(User::class)->create();
        $this->assertDatabaseMissing('tickets', [
            'user_id' => $user->id
        ]);
        $this->assertFalse(in_array(config('lanparty.session'),$user->inscription_paid));
        $this->expectException(NotEnoughTicketsException::class);
        $user->pay(config('lanparty.session'));
    }

    /** @test */
    function user_can_unpay()
    {
        seed_database();
        $user = factory(User::class)->create();
        $user->pay(config('lanparty.session'));
        $this->assertTrue(in_array(config('lanparty.session'),$user->inscription_paid));
        $user->unpay(config('lanparty.session'));
        $user = $user->fresh();
        $this->assertFalse(in_array(config('lanparty.session'),$user->inscription_paid));
    }

    /** @test */
    function totalToPay()
    {
        $user = factory(User::class)->create();

        $this->assertEquals(config('lanparty.inscription_price'), $user->total_to_pay);
        create_inscription_types();

        $event = Event::firstOrCreate([
            'name' => 'FIFA 18',
            'session' => config('lanparty.session'),
            'inscription_type_id' => InscriptionType::where('value', 'individual')->first()->id,
            'image' => '/img/Fifa18.jpeg',
            'regulation' => 'https://docs.google.com/document/d/1YDxnnqIt_Wixy5itQoHWT5-n37G5-I2TY0oHzdPscWM/edit',
            'published_at' => Carbon::now(),
            'participants_number' => 15
        ]);
        $event->addTickets(1);
        $event->registerUser($user);
        $user = $user->fresh();
        $this->assertEquals(config('lanparty.inscription_price') + config('lanparty.event_inscription_price'), $user->total_to_pay);

        $event2 = Event::firstOrCreate([
            'name' => 'Counter Strike',
            'inscription_type_id' => InscriptionType::where('value', 'group')->first()->id,
            'image' => '/img/CounterStrike.jpeg',
            'participants_number' => 3,
            'regulation' => 'https://docs.google.com/document/d/1ZMUBSAYHz79JSWkbv9Ra0HLfO2WGJHkLW6xDYHa4Pks/edit',
            'published_at' => '2018-01-15 12:00:00',
        ]);
        $event2->addTickets(1);
        $group = Group::create([
            'name' => 'Panchos'
        ]);
        $group->add($user);
        $event2->registerGroup($group);

        $user = $user->fresh();
        $this->assertEquals(config('lanparty.inscription_price') + 2*config('lanparty.event_inscription_price'), $user->total_to_pay);
        $event2->unregisterGroup($group);
        $user = $user->fresh();
        $this->assertEquals(config('lanparty.inscription_price') + config('lanparty.event_inscription_price'), $user->total_to_pay);

        $event->unregisterUser($user);
        $user = $user->fresh();
        $this->assertEquals(config('lanparty.inscription_price'), $user->total_to_pay);
    }

}
