<?php

namespace Tests\Unit;

use Acacha\User\GuestUser;
use App\User;
use Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class HelpersTest.
 *
 * @package Tests\Unit
 */
class HelpersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function formatted_logged_user_test()
    {
        Auth::login($user = factory(User::class)->create());
        $formatted_user = json_decode(formatted_logged_user());

        $this->assertEquals($user->id,$formatted_user->id);
        $this->assertEquals($user->name,$formatted_user->name);
        $this->assertEquals($user->email,$formatted_user->email);
    }

    /** @test */
    public function formatted_logged_user_test_with_user_not_logged()
    {
        $formatted_user = formatted_logged_user();
        $this->assertInstanceOf(GuestUser::class,$formatted_user);
    }
}
