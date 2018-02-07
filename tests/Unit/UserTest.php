<?php

namespace Tests\Unit;

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
    /** @test */
    function can_get_formatted_created_at_date()
    {
        $concert = factory(User::class)->make([
            'created_at' => Carbon::parse('2016-12-01 8:00pm'),
        ]);

        $this->assertEquals('08:00:00PM 01-12-2016', $concert->formatted_created_at_date);
    }
}
