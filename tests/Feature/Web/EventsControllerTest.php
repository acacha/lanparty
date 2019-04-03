<?php

namespace Tests\Feature\web;

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
    public function manager_can_see_events_module()
    {
        $this->loginAsManager('web');
        $response = $this->json('GET','/manage/events');
        $response->assertSuccessful();
        $response->assertViewIs('manage.events.index');
        $response->assertViewHas('events');
    }

    /** @test */
    public function superadmin_can_see_events_module()
    {
        $this->withoutExceptionHandling();
        $this->loginAsSuperAdmin('web');
        $response = $this->json('GET','/manage/events');
//        dd('hola');
        $response->assertSuccessful();
        $response->assertViewIs('manage.events.index');
//        $response->assertViewHas('events');
    }

    /** @test */
    public function regular_user_cannot_see_events_module()
    {
        $this->login('web');
        $response = $this->json('GET','/manage/events');
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_user_cannot_see_events_module()
    {
        $response = $this->json('GET','/manage/events');
        $response->assertStatus(401);
    }

}
