<?php

namespace Tests\Feature;

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
    use RefreshDatabase;

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
