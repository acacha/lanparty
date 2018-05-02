<?php

namespace Tests\Feature;

use App\Event;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class UnregisterUserToAllEventsTest.
 *
 * @package Tests\Feature
 */
class UnregisterUserToAllEventsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_manager_can_unregister_an_user_to_all_events()
    {
        $this->withoutExceptionHandling();
        seed_database();
        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');
        $this->actingAs($manager,'api');

        $participant = factory(User::class)->create();

        $events = Event::inRandomOrder()->published()->where('inscription_type_id',2)->get();
        $event = $events[0];
        $event->registerUser($participant);
        $event = $event->fresh();

        $this->assertTrue($event->hasParticipant($participant));

        $response= $this->json('DELETE','/api/v1/events/register/user/' . $participant->id);

        $response->assertSuccessful();
        $event = $event->fresh();

        $this->assertFalse($event->hasParticipant($participant));

    }

}
