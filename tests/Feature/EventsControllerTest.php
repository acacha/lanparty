<?php

namespace Tests\Feature;

use App\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class EventsControllerTest.
 *
 * @package Tests\Feature
 */
class EventsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_events()
    {
        $this->withoutExceptionHandling();
        seed_database();
        $response = $this->json('GET','api/v1/events');
        $response->assertSuccessful();
        $this->assertCount(Event::published()->count(),json_decode($response->getContent()));
        $response->assertJsonStructure([[
            'id',
            'name',
            'inscription_type_id',
            'image',
            'published_at',
            'created_at',
            'updated_at',
            'inscribed',
            'tickets',
            'available_tickets',
            'assigned_tickets',
            'registrations'
        ]]);
    }
}
