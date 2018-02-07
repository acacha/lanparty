<?php

namespace Tests\Unit;

use App\Number;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class NumberTest
 * @package Tests\Unit
 */
class NumberTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_assign_user()
    {
        $user = factory(User::class)->create();
        $number = factory(Number::class)->create();
        $number->assignUser($user);
        $this->assertEquals($user, $number->user);

    }
}
