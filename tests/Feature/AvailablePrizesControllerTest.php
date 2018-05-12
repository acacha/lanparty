<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class AvailablePrizesControllerTest.
 *
 * @package Tests\Feature
 */
class AvailablePrizesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_list_available_prizes()
    {
        $this->withoutExceptionHandling();
        $response = $this->json('GET','/api/v1/available_prizes');
        $response->assertSuccessful();
    }
}
