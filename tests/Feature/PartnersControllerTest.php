<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PartnersControllerTest.
 *
 * @package Tests\Feature
 */
class PartnersControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_partners()
    {
        $response = $this->get('colaboradors');
        $response->assertSuccessful();
        $response->assertViewIs('partners');
        $response->assertViewHas('partners');;
    }
}
