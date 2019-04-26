<?php

namespace Tests\Feature\Api;

use App\Event;
use App\InscriptionType;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ArchivedEventsControllerTest.
 *
 * @package Tests\Feature
 */
class ArchivedEventsControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /** @test */
    public function manager_can_archive_event()
    {
        create_inscription_types();
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => InscriptionType::where('value','group')->first()->id,
            'image' => '/img/LoL.jpeg',
            'participants_number' => 5,
            'regulation' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
            'published_at' => '2018-01-15 12:00:00'
        ]);
        $this->loginAsManager('api');
        $this->assertFalse($event->trashed());
        $response = $this->json('POST','/api/v1/archived_events/' . $event->id);
        $response->assertSuccessful();
        $event= $event->fresh();
        $this->assertTrue($event->trashed());
    }

    /** @test */
    public function superadmin_can_archive_event()
    {
        create_inscription_types();
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => InscriptionType::where('value','group')->first()->id,
            'image' => '/img/LoL.jpeg',
            'participants_number' => 5,
            'regulation' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
            'published_at' => '2018-01-15 12:00:00'
        ]);
        $this->loginAsSuperAdmin('api');
        $this->assertFalse($event->trashed());
        $response = $this->json('POST','/api/v1/archived_events/' . $event->id);
        $response->assertSuccessful();
        $event= $event->fresh();
        $this->assertTrue($event->trashed());
    }

    /** @test */
    public function regular_user_cannot_archive_event()
    {
        create_inscription_types();
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => InscriptionType::where('value','group')->first()->id,
            'image' => '/img/LoL.jpeg',
            'participants_number' => 5,
            'regulation' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
            'published_at' => '2018-01-15 12:00:00'
        ]);
        $this->login('api');
        $this->assertFalse($event->trashed());
        $response = $this->json('POST','/api/v1/archived_events/' . $event->id);
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_user_cannot_archive_event()
    {
        create_inscription_types();
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => InscriptionType::where('value','group')->first()->id,
            'image' => '/img/LoL.jpeg',
            'participants_number' => 5,
            'regulation' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
            'published_at' => '2018-01-15 12:00:00'
        ]);
        $this->assertFalse($event->trashed());
        $response = $this->json('POST','/api/v1/archived_events/' . $event->id);
        $response->assertStatus(401);
    }

    /** @test */
    public function manager_can_unarchive_event()
    {
        create_inscription_types();
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => InscriptionType::where('value','group')->first()->id,
            'image' => '/img/LoL.jpeg',
            'participants_number' => 5,
            'regulation' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
            'published_at' => '2018-01-15 12:00:00'
        ]);
        $event->delete();
        $this->loginAsManager('api');
        $this->assertTrue($event->trashed());
        $response = $this->json('DELETE','/api/v1/archived_events/' . $event->id);
        $response->assertSuccessful();
        $event= $event->fresh();
        $this->assertFalse($event->trashed());
    }

    /** @test */
    public function superadmin_can_unarchive_event()
    {
        create_inscription_types();
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => InscriptionType::where('value','group')->first()->id,
            'image' => '/img/LoL.jpeg',
            'participants_number' => 5,
            'regulation' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
            'published_at' => '2018-01-15 12:00:00'
        ]);
        $event->delete();
        $this->loginAsSuperAdmin('api');
        $this->assertTrue($event->trashed());
        $response = $this->json('DELETE','/api/v1/archived_events/' . $event->id);
        $response->assertSuccessful();
        $event= $event->fresh();
        $this->assertFalse($event->trashed());
    }

    /** @test */
    public function regular_user_cannot_unarchive_event()
    {
        create_inscription_types();
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => InscriptionType::where('value','group')->first()->id,
            'image' => '/img/LoL.jpeg',
            'participants_number' => 5,
            'regulation' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
            'published_at' => '2018-01-15 12:00:00'
        ]);
        $event->delete();
        $this->login('api');
        $this->assertTrue($event->trashed());
        $response = $this->json('DELETE','/api/v1/archived_events/' . $event->id);
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_user_cannot_unarchive_event()
    {
        create_inscription_types();
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => InscriptionType::where('value','group')->first()->id,
            'image' => '/img/LoL.jpeg',
            'participants_number' => 5,
            'regulation' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
            'published_at' => '2018-01-15 12:00:00'
        ]);
        $event->delete();
        $this->assertTrue($event->trashed());
        $response = $this->json('DELETE','/api/v1/archived_events/' . $event->id);
        $response->assertStatus(401);
    }

}
