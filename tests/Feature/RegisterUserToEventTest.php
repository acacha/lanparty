<?php

namespace Tests\Feature;

use App\Event;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class RegisterUserToEventControllerTest.
 *
 * @package Tests\Feature
 */
class RegisterUserToEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_manager_can_register_an_user_to_event()
    {
        seed_database();
        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $participant = factory(User::class)->create();

        $event = Event::inRandomOrder()->published()->where('inscription_type_id',2)->first();

        $this->assertFalse($event->hasParticipant($participant));

        $response= $this->json('POST','/api/v1/events/' . $event->id . '/register/user/' . $participant->id);

        $response->assertSuccessful();
        $event = $event->fresh();
        $this->assertTrue($event->hasParticipant($participant));
    }

    /** @test */
    public function no_managers_cannnot_register_an_user_to_event()
    {
        seed_database();
        $participant = factory(User::class)->create();
        $this->actingAs($participant,'api');
        $anotherParticipant = factory(User::class)->create();
        $event = Event::inRandomOrder()->published()->where('inscription_type_id',2)->first();

        $response= $this->json('POST','/api/v1/events/' . $event->id . '/register/user/' . $anotherParticipant->id);

        $response->assertStatus(403);
    }

    /** @test */
    public function cannot_register_user_to_unpublished_event()
    {
        seed_database();
        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $participant = factory(User::class)->create();

        $event = Event::inRandomOrder()->unpublished()->where('inscription_type_id',2)->first();

        $response= $this->json('POST','/api/v1/events/' . $event->id . '/register/user/' . $participant->id);

        $response->assertStatus(422);
        $this->assertEquals('No es pot registrar un usuari a un esdeveniment sense publicar', json_decode($response->getContent())->message);
        $this->assertCount(0,$event->users);
        $this->assertCount(0,$participant->events);
    }

    /** @test */
    public function cannot_register_already_registered_user_to_event()
    {
        seed_database();
        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $participant = factory(User::class)->create();

        $event = Event::inRandomOrder()->published()->where('inscription_type_id',2)->first();

        $event->registerUser($participant);
        $response= $this->json('POST','/api/v1/events/' . $event->id . '/register/user/' . $participant->id);

        $response->assertStatus(422);
        $this->assertEquals("L'usuari ja està apuntat a l'esdeveniment!", json_decode($response->getContent())->message);
        $this->assertEquals($event->users()->first()->id, $participant->id);
        $this->assertEquals($participant->events()->first()->id, $event->id);
    }

    /** @test */
    public function a_manager_can_unregister_an_user_to_event()
    {
        seed_database();
        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $participant = factory(User::class)->create();

        $event = Event::inRandomOrder()->published()->where('inscription_type_id',2)->first();
        $event->registerUser($participant);
        $event = $event->fresh();
        $this->assertTrue($event->hasParticipant($participant));
        $response= $this->json('DELETE','/api/v1/events/' . $event->id . '/register/user/' . $participant->id);

        $response->assertSuccessful();
        $event = $event->fresh();
        $this->assertFalse($event->hasParticipant($participant));
    }

    /** @test */
    public function not_managers_cannot_unregister_an_user_to_event()
    {
        seed_database();
        $hacker = factory(User::class)->create();
        $this->actingAs($hacker,'api');

        $participant = factory(User::class)->create();

        $event = Event::inRandomOrder()->published()->where('inscription_type_id',2)->first();
        $event->registerUser($participant);
        $event = $event->fresh();
        $this->assertTrue($event->hasParticipant($participant));
        $response= $this->json('DELETE','/api/v1/events/' . $event->id . '/register/user/' . $participant->id);

        $response->assertStatus(403);
    }
}
