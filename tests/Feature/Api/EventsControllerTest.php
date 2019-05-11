<?php

namespace Tests\Feature\Api;

use App\Event;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class EventsControllerTest.
 *
 * @package Tests\Feature
 */
class EventsControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /** @test */
    public function manager_can_get_events_module()
    {
        $this->loginAsManager('api');
        $response = $this->json('GET','/api/v1/events');
        $response->assertSuccessful();

    }

    /** @test */
    public function superadmin_can_get_events_module()
    {
//        $this->withoutExceptionHandling();
        $this->loginAsSuperAdmin('api');
        $response = $this->json('GET','/api/v1/events');
//        dd('hola');
        $response->assertSuccessful();
//        $response->assertViewIs('events.index');
//        $response->assertViewHas('events');
    }

    /** @test */
    public function regular_user_can_get_events_module()
    {
        $this->login('api');
        $response = $this->json('GET','/api/v1/events');
        $response->assertStatus(200);
    }

    /** @test */
    public function guest_user_can_get_events_module()
    {
        $response = $this->json('GET','/api/v1/events');
        $response->assertStatus(200);
    }


    /** @test */
    public function can_fetch_events()
    {
        seed_database();
        $response = $this->json('GET','/api/v1/events');
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
            'registrations',
            'regulation'
        ]]);
    }

    /**
     * @test
     */
    public function manager_can_create_event()
    {
        $this->withoutExceptionHandling();
//        dd('hola');
        $event = factory(Event::class)->create();
        $eventArr = json_decode(json_encode($event), true);

        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/events',$eventArr);
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertNotNull($event = Event::find($result->id));
        $this->assertEquals($event->name,$result->name);
        $this->assertEquals($event->id,$result->id);
        $this->assertEquals($event->session,$result->session);



    }
    /**
     * @test
     */
    public function superadmin_can_create_event()
    {
        $this->withoutExceptionHandling();
//        dd('hola');
        $event = factory(Event::class)->create();
        $eventArr = json_decode(json_encode($event), true);

        $this->loginAsSuperAdmin('api');
        $response = $this->json('POST','/api/v1/events',$eventArr);
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertNotNull($event = Event::find($result->id));
        $this->assertEquals($event->name,$result->name);
        $this->assertEquals($event->id,$result->id);
        $this->assertEquals($event->session,$result->session);

    }
    /**
     * @test
     */
    public function regular_user_cannot_create_event()
    {
        $event = factory(Event::class)->create();
        $eventArr = json_decode(json_encode($event), true);

        $this->login('api');
        $response = $this->json('POST','/api/v1/events',$eventArr);
//        $result = json_decode($response->getContent());
        $response->assertStatus(403);
    }
    /** @test */
    function guest_user_cannot_create_events()
    {
//        $this->withoutExceptionHandling();
//        $this->login('api');
        $event = factory(Event::class)->create();
        $eventArr = json_decode(json_encode($event), true);
        $response = $this->json('POST','/api/v1/events',$eventArr);
        $response->assertStatus(401);
    }
//
    /** @test */
    function manager_can_show_events()
    {
//        $this->withoutExceptionHandling();
        $this->loginAsManager('api');
        $event = factory(Event::class)->create();
        $response = $this->json('GET','/api/v1/events/' . $event->id);
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertEquals($event->name, $result->name);
        $this->assertEquals($event->image,  $result->image);

    }

    /** @test */
    function superadmin_can_show_events()
    {
//        $this->withoutExceptionHandling();
        $this->loginAsSuperAdmin('api');
        $event = factory(Event::class)->create();
        $response = $this->json('GET','/api/v1/events/' . $event->id);
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertEquals($event->name, $result->name);
        $this->assertEquals($event->image,  $result->image);
        $this->assertEquals($event->session,$result->session);

//        $response->assertViewIs('manage.events.index');
    }

    /** @test */
    function regular_user_cannot_show_events()
    {
        $this->login('api');
        $event = factory(Event::class)->create();
        $response = $this->json('GET','/api/v1/events/' . $event->id);
        $response->assertStatus(403);
    }
        // OAUTHKEY doesn't exist or not readable, do -> passport install
    /** @test */
    function guest_user_cannot_show_events()
    {
//        $this->withoutExceptionHandling();
//        $this->login('api');
        $event = factory(Event::class)->create();
        $response = $this->json('GET','/api/v1/events/' . $event->id);
        $response->assertStatus(401);
    }

    /** @test */
    function manager_can_destroy_events()
    {
        $this->withoutExceptionHandling();
        $this->loginAsManager('api');
        $event = factory(Event::class)->create();
        $response = $this->json('DELETE','/api/v1/events/' . $event->id);
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertEquals($result->name, $event->name);
        $this->assertNull(Event::find($event->id));
//        $this->assertEquals($event->name, $result->name);
//        $this->assertEquals($event->image,  $result->image);

    }

    /** @test */
    function superadmin_can_destroy_events()
    {
//        $this->withoutExceptionHandling();
        $this->loginAsSuperAdmin('api');
        $event = factory(Event::class)->create();
        $response = $this->json('DELETE','/api/v1/events/' . $event->id);
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertEquals($result->name, $event->name);
        $this->assertNull(Event::find($event->id));
//        $response->assertViewIs('manage.events.index');
    }

    /** @test */
    function regular_user_cannot_destroy_events()
    {
        $this->login('api');
        $event = factory(Event::class)->create();
        $response = $this->json('DELETE','/api/v1/events/' . $event->id);
        $response->assertStatus(403);
    }
    /** @test */
    function guest_user_cannot_destroy_events()
    {
//        $this->login('api');
        $event = factory(Event::class)->create();
        $response = $this->json('DELETE','/api/v1/events/' . $event->id);
        $response->assertStatus(401);
    }

    /** @test */
    function manager_can_update_events()
    {
        $this->withoutExceptionHandling();
        $this->loginAsManager('api');
        $oldEvent = factory(Event::class)->create([
            'name' => 'Comprar llet',
            'session'=>'2018'
        ]);
        $event = factory(Event::class)->create();
        $eventArr = json_decode(json_encode($event), true);
//        dump($eventArr['name']);


        $response = $this->json('PUT','/api/v1/events/' . $oldEvent->id, $eventArr);
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $newTask = $oldEvent->refresh();
        $this->assertNotNull($newTask);
        $this->assertEquals($eventArr['name'],$result->name);
        $this->assertEquals($eventArr['session'],$result->session);
//        dump($newTask->name);
//        $result = json_decode($response->getContent());
//        $response->assertSuccessful();
//        $this->assertEquals($result->name, $event->name);
//        $this->assertEquals($event->image,  $result->image);

    }

    /** @test */
    function superadmin_can_update_events()
    {
//        $this->withoutExceptionHandling();
        $this->loginAsSuperAdmin('api');
        $oldEvent = factory(Event::class)->create([
            'name' => 'Comprar llet'
        ]);
        $event = factory(Event::class)->create();
        $eventArr = json_decode(json_encode($event), true);


        $response = $this->json('PUT','/api/v1/events/' . $oldEvent->id, $eventArr);
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $newTask = $oldEvent->refresh();
        $this->assertNotNull($newTask);
        $this->assertEquals($eventArr['name'],$result->name);
        $this->assertEquals($eventArr['session'],$result->session);

//        $response->assertViewIs('manage.events.index');
    }

    /** @test */
    function regular_user_cannot_update_events()
    {
        $this->login('api');
        $oldEvent = factory(Event::class)->create([
            'name' => 'Comprar llet'
        ]);
        $event = factory(Event::class)->create();
        $eventArr = json_decode(json_encode($event), true);

        $response = $this->json('PUT','/api/v1/events/' . $oldEvent->id, $eventArr);

        $response->assertStatus(403);
    }

    /** @test */
    function guest_user_cannot_update_events()
    {
        $oldEvent = factory(Event::class)->create([
            'name' => 'Comprar llet'
        ]);
        $event = factory(Event::class)->create();
        $eventArr = json_decode(json_encode($event), true);

        $response = $this->json('PUT','/api/v1/events/' . $oldEvent->id, $eventArr);

        $response->assertStatus(401);
    }

}
