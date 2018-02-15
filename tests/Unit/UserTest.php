<?php

namespace Tests\Unit;

use App\Event;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class UserTest
 * @package Tests\Unit
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

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
}
