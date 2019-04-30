<?php

namespace Tests\Unit;

use App\Exceptions\NotEnoughTicketsException;
use App\Role;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class UserTest
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
        $this->assertCount(0, $user->inscription_paid);
        $user->pay('2018');
        $user->fresh();
        $this->assertDatabaseHas('tickets', [
            'user_id' => $user->id
        ]);
        $this->assertCount(1, Ticket::where('user_id', $user->id)->get());

        $this->assertEquals(true, $user->inscription_paid['2018']);
    }

    /** @test */
    function user_cannot_pay_if_no_more_ticket_are_available()
    {
        $user = factory(User::class)->create();
        $this->assertDatabaseMissing('tickets', [
            'user_id' => $user->id
        ]);
        $this->assertCount(0, $user->inscription_paid);
        $this->expectException(NotEnoughTicketsException::class);
        $user->pay('2018');
    }

    /** @test */
    function user_can_unpay()
    {
        seed_database();
        $user = factory(User::class)->create();
        $user->pay('2018');
        $this->assertEquals(true, $user->inscription_paid['2018']);
        $user->unpay();
        $this->assertCount(0,$user->inscription_paid);
    }
}
