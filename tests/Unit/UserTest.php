<?php

namespace Tests\Unit;

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
        $this->assertNotNull($mappedUser['created_at']);
        $this->assertNotNull($mappedUser['updated_at']);
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
        $this->assertEquals(false, $user->inscription_paid);
        $user->pay();
        $user->fresh();
        $this->assertDatabaseHas('tickets', [
            'user_id' => $user->id
        ]);
        $this->assertEquals(true, $user->inscription_paid);
    }

    /** @test */
    function user_can_unpay()
    {
        seed_database();
        $user = factory(User::class)->create();
        $user->pay();
        $this->assertEquals(true, $user->inscription_paid);
        $user->unpay();
        $this->assertEquals(false, $user->inscription_paid);
    }
}
