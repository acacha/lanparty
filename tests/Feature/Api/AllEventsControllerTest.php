<?php

namespace Tests\Feature\Api;

use App\Event;
use App\InscriptionType;
use Carbon\Carbon;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class AllEventsControllerTest.
 *
 * @package Tests\Feature
 */
class AllEventsControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /** @test */
    public function manager_can_get_all_events_module()
    {
        create_inscription_types();
        $events = [
            [
                'name' => 'League Of Legends',
                'inscription_type' => 'group',
                'image' => '/img/LoL.jpeg',
                'tickets' => 10, // Número de grups,
                'participants_number' => 5,
                'regulation' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
                'published_at' => '2018-01-15 12:00:00',
                'deleted_at' => null
            ],
            [
                'name' => 'Overwatch',
                'inscription_type' => 'group',
                'image' => '/img/Overwatch.jpeg',
                'tickets' => 10, // Número de grups
                'participants_number' => 6,
                'regulation' => 'https://docs.google.com/document/d/1OlM3ZcxyxiIz51R_tYeYiA1-lfiK-lyG-tMhRm8DHSk/edit',
                'published_at' => null,
                'deleted_at' => null
            ],
            [
                'name' => 'Counter Strike',
                'inscription_type' => 'group',
                'image' => '/img/CounterStrike.jpeg',
                'tickets' => 10, // Número d'usuaris es poden inscriure
                'participants_number' => 3,
                'regulation' => 'https://docs.google.com/document/d/1ZMUBSAYHz79JSWkbv9Ra0HLfO2WGJHkLW6xDYHa4Pks/edit',
                'published_at' => '2018-01-15 12:00:00',
                'deleted_at' => '2018-01-17 12:00:00',
            ]
        ];

        foreach ($events as $event) {
            $createdEvent = Event::firstOrCreate([
                'name' => $event['name'],
                'inscription_type_id' => InscriptionType::where('value',$event['inscription_type'])->first()->id,
                'image' => $event['image'],
                'regulation' => $event['regulation'],
                'published_at' => $event['published_at'] ? Carbon::parse($event['published_at']) : null,
                'participants_number' => $event['participants_number']
            ]);
        }
        $this->loginAsManager('api');
        $response = $this->json('GET','/api/v1/all_events');
        $response->assertSuccessful();
        $result = json_decode($response->getContent());
        $this->assertCount(3,$result);
    }

    /** @test */
    public function superadmin_can_get_all_events_module()
    {
        create_inscription_types();
        $events = [
            [
                'name' => 'League Of Legends',
                'inscription_type' => 'group',
                'image' => '/img/LoL.jpeg',
                'tickets' => 10, // Número de grups,
                'participants_number' => 5,
                'regulation' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
                'published_at' => '2018-01-15 12:00:00',
                'deleted_at' => null
            ],
            [
                'name' => 'Overwatch',
                'inscription_type' => 'group',
                'image' => '/img/Overwatch.jpeg',
                'tickets' => 10, // Número de grups
                'participants_number' => 6,
                'regulation' => 'https://docs.google.com/document/d/1OlM3ZcxyxiIz51R_tYeYiA1-lfiK-lyG-tMhRm8DHSk/edit',
                'published_at' => null,
                'deleted_at' => null
            ],
            [
                'name' => 'Counter Strike',
                'inscription_type' => 'group',
                'image' => '/img/CounterStrike.jpeg',
                'tickets' => 10, // Número d'usuaris es poden inscriure
                'participants_number' => 3,
                'regulation' => 'https://docs.google.com/document/d/1ZMUBSAYHz79JSWkbv9Ra0HLfO2WGJHkLW6xDYHa4Pks/edit',
                'published_at' => '2018-01-15 12:00:00',
                'deleted_at' => '2018-01-17 12:00:00',
            ]
        ];

        foreach ($events as $event) {
            $createdEvent = Event::firstOrCreate([
                'name' => $event['name'],
                'inscription_type_id' => InscriptionType::where('value',$event['inscription_type'])->first()->id,
                'image' => $event['image'],
                'regulation' => $event['regulation'],
                'published_at' => $event['published_at'] ? Carbon::parse($event['published_at']) : null,
                'participants_number' => $event['participants_number']
            ]);
        }
        $this->loginAsSuperAdmin('api');
        $response = $this->json('GET','/api/v1/all_events');
        $response->assertSuccessful();
        $result = json_decode($response->getContent());
        $this->assertCount(3,$result);
    }

    /** @test */
    public function regular_user_cannot_get_all_events_module()
    {
        $this->login('api');
        $response = $this->json('GET','/api/v1/all_events');
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_user_cannot_get_all_events_module()
    {
        $response = $this->json('GET','/api/v1/all_events');
        $response->assertStatus(401);
    }
}
