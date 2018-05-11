<?php

namespace Tests\Unit;

use App\Partner;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PartnerTest.
 *
 * @package Tests\Unit
 */
class PartnerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_find_by_name()
    {
        $this->assertNull(Partner::findByName('Ajuntament de Tortosa'));

        $partner = Partner::create([
            'name' => 'Ajuntament de Tortosa',
            'category' => 'Or'
        ]);

        $this->assertTrue($partner->is(Partner::findByName('Ajuntament de Tortosa')));
    }
}
