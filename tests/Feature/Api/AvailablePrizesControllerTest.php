<?php

namespace Tests\Feature\Api;

use Tests\Feature\Traits\CanLogin;
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
    use RefreshDatabase,CanLogin;

    /** @test */
    public function prizes_could_be_publicly_seen()
    {
        initialize_partners();
        initialize_prizes();
        $response = $this->json('GET','/api/v1/available_prizes');
        $response->assertSuccessful();
        $result= json_decode($response->getContent());
        $this->assertEquals(1,$result[0]->id);
        $this->assertEquals('Samarreta LAN Party',$result[0]->name);
        $this->assertNull($result[0]->user_id);
        $this->assertNull($result[0]->number_id);
    }

}
