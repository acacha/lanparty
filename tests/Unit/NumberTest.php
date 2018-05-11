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
        $this->assertSame(null, Number::last());
        foreach (range(1, 100) as $value) {
            Number::create([
                'value' => $value
            ]);
        }
        $this->assertEquals(100, Number::last());
        foreach (range(101, 150) as $value) {
            Number::create([
                'value' => $value
            ]);
        }
        $this->assertEquals(150, Number::last());
    }

    /** @test */
    public function numbers_can_be_added()
    {
        Number::addNumbers(100);
        $this->assertCount(100,Number::all());
        Number::addNumbers(100);

        $this->assertCount(200,Number::all());
    }

    /** @test */
    public function can_get_first_available_number()
    {
        $this->assertSame(Number::firstAvailableNumber(), null);
        Number::addNumbers(5);
        $this->assertEquals(1,Number::firstAvailableNumber()->value);
        Number::firstAvailableNumber()->assignUser(Factory(User::class)->create());
        $this->assertEquals(2, Number::firstAvailableNumber()->value);
        $number = Number::firstAvailableNumber();
        $number->assignUser(Factory(User::class)->create());
        $this->assertEquals(3, Number::firstAvailableNumber()->value);
        $number->update(['user_id' => null]);
        $number->save();
        $this->assertEquals(2, Number::firstAvailableNumber()->value);
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
