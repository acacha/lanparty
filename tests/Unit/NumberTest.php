<?php

namespace Tests\Unit;

use App\Number;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class NumberTest
 * @package Tests\Unit
 */
class NumberTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_assign_user()
    {
        $user = factory(User::class)->create();
        $number = factory(Number::class)->create();
        $number->assignUser($user);
        $this->assertEquals($user, $number->user);

    }

    /** @test */
    public function can_get_last_number_value()
    {
        $this->assertSame(null, Number::last(config('lanparty.test')));
        foreach (range(1, 100) as $value) {
            Number::create([
                'value' => $value
            ]);
        }
        $this->assertEquals(100, Number::last(config('lanparty.test')));
        foreach (range(101, 150) as $value) {
            Number::create([
                'value' => $value
            ]);
        }
        $this->assertEquals(150, Number::last(config('lanparty.test')));
    }

    /** @test */
    public function numbers_can_be_added()
    {
        Number::addNumbers(10, config('lanparty.session'));
        $this->assertCount(10,Number::all());
        Number::addNumbers(10, config('lanparty.session'));

        $this->assertCount(20,$numbers=Number::all());
        $this->assertEquals(config('lanparty.session'),$numbers[0]->session);

    }

    /** @test */
    public function can_get_first_available_number()
    {
        $this->assertSame(Number::firstAvailableNumber(config('lanparty.session')), null);
        Number::addNumbers(5,config('lanparty.session'));
        $this->assertEquals(1,Number::firstAvailableNumber(config('lanparty.session'))->value);
        Number::firstAvailableNumber(config('lanparty.session'))->assignUser(Factory(User::class)->create());
        $this->assertEquals(2, Number::firstAvailableNumber(config('lanparty.session'))->value);
        $number = Number::firstAvailableNumber(config('lanparty.session'));
        $number->assignUser(Factory(User::class)->create());
        $this->assertEquals(3, Number::firstAvailableNumber(config('lanparty.session'))->value);
        $number->update(['user_id' => null]);
        $number->save();
        $this->assertEquals(2, Number::firstAvailableNumber(config('lanparty.session'))->value);
    }

    /** @test */
    function can_get_full_search_attribute()
    {

        $number = factory(Number::class)->create([
            'value' => 1,
            'description' => 'Assistència matí divendres'
        ]);

        $this->assertEquals('1 Assistència matí divendres', $number->full_search);

        $user = factory(User::class)->create([
            'name' => 'Acacha',
            'sn1' => 'Tur',
            'sn2' => 'Badenas',
            'givenName' => 'Sergi'
        ]);

        $number->assignUser($user,'Assistència matí divendres');

        $this->assertEquals('1 Assistència matí divendres Sergi Tur Badenas Acacha', $number->full_search);
    }
}
