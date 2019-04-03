<?php

namespace Tests\Feature;

use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PrizesControllerTest.
 *
 * @package Tests\Feature
 */
class PrizesControllerTest extends TestCase
{
    use RefreshDatabase,CanLogin;

    /** @test */
    public function prizes_could_be_publicly_seen()
    {
        $response = $this->get('premis');
        $response->assertSuccessful();
        $response->assertViewIs('prizes');
        $response->assertViewHas('prizes');
    }

    /** @test */
    public function can_list_prizes()
    {
        $response = $this->json('GET','/api/v1/prizes');
        $response->assertSuccessful();
    }
}
