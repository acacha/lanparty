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
    public function partners_could_be_publicly_seen()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('partners');
        $response->assertSuccessful();
        $response->assertViewIs('partners');
        $response->assertViewHas('partners');
    }

    /** @test */
    public function can_list_partners()
    {
        $this->withoutExceptionHandling();
        $response = $this->json('GET','/api/v1/partners');
        $response->assertSuccessful();
    }
}
