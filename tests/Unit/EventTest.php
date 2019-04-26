<?php

namespace Tests\Unit;

use App\Event;
use App\Exceptions\GroupAlreadyInscribedException;
use App\Exceptions\InscriptionException;
use App\Exceptions\UserAlreadyInscribedException;
use App\Group;
use App\InscriptionType;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class EventTest.
 *
 * @package Tests\Unit
 */
class EventTest extends TestCase
{
    protected $user;

    use RefreshDatabase;

    /** @test */
    public function can_add_tickets_to_events()
    {
        $event = Event::firstOrCreate([
            'name' => 'League Of Legends',
            'inscription_type_id' => 1,
            'image' => 'img/LoL.jpeg',
            'regulation' => 'http://example.com/regulation'
        ]);
        $event->addTickets(50);
        $this->assertEquals(count($event->registrations), 50);
    }

    /** @test */
    public function can_get_total_tickets()
    {
        $event = Event::firstOrCreate([
            'name' => 'League Of Legends',
            'inscription_type_id' => 1,
            'image' => 'img/LoL.jpeg',
            'regulation' => 'http://example.com/regulation'
        ]);
        $event->addTickets(50);
        $this->assertEquals($event->tickets, 50);
    }

    /** @test */
    public function can_get_available_tickets()
    {
        $event = Event::firstOrCreate([
            'name' => 'League Of Legends',
            'inscription_type_id' => 1,
            'image' => 'img/LoL.jpeg',
            'regulation' => 'http://example.com/regulation'
        ]);
        $event->addTickets(50);
        $this->assertEquals($event->available_tickets, 50);
    }

    /** @test */
    public function can_get_assigned_tickets()
    {
        $event = Event::firstOrCreate([
            'name' => 'League Of Legends',
            'inscription_type_id' => 1,
            'image' => 'img/LoL.jpeg',
            'regulation' => 'http://example.com/regulation'
        ]);
        $event->addTickets(50);
        $this->assertSame($event->assigned_tickets, 0);
    }

    /** @test */
    public function can_register_users()
    {
        seed_database();
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',2)->get()->first();
        $user = factory(User::class)->create();
        $event->inscribeUser($user);
        $event = $event->fresh();
        $this->assertEquals($event->users->first()->id, $user->id);
        $this->assertEquals($user->events->first()->id, $event->id);
    }

    /** @test */
    public function cannot_register_users_to_events_of_type_groupal()
    {
        seed_database();
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->first();
        $user = factory(User::class)->create();
        try {
            $event->inscribeUser($user);
        } catch (InscriptionException $exception) {
            $this->assertEquals(count($event->users), 0);
            $this->assertEquals(count($user->events), 0);
            return;
        }

        $this->fail('An user cannot be assigned to an event of type groupal');
    }

    /** @test */
    public function cannot_register_user_already_registered()
    {
        seed_database();
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',2)->get()->first();
        $user = factory(User::class)->create();
        $event->inscribeUser($user);
        $event = $event->fresh();
        try {
            $event->inscribeUser($user);
        } catch (UserAlreadyInscribedException $exception) {
            $this->assertEquals(count($event->users), 1);
            $this->assertEquals(count($user->events), 1);
            return;
        }

        $this->fail('An user cannot be registered two times to an event');
    }

    /** @test */
    public function can_register_groups()
    {
        seed_database();
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->first();
        $group = factory(Group::class)->create();
        $event->inscribeGroup($group);
        $event = $event->fresh();

        $this->assertEquals($event->groups->first()->id, $group->id);
        $this->assertEquals($group->events->first()->id, $event->id);
    }

    /** @test */
    public function cannot_register_groups_to_events_of_type_individual()
    {
        seed_database();
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',2)->first();
        $group = factory(Group::class)->create();
        try {
            $event->inscribeGroup($group);
        } catch (InscriptionException $exception) {
            $this->assertEquals($event->group, null);
            $this->assertEquals(count($group->events), 0);
            return;
        }

        $this->fail('An group cannot be assigned to an event of type individual');
    }

    /** @test */
    public function cannot_register_group_already_registered()
    {
        seed_database();
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->get()->first();
        $group = factory(Group::class)->create();
        $event->inscribeGroup($group);
        $event = $event->fresh();
        try {
            $event->inscribeGroup($group);
        } catch (GroupAlreadyInscribedException $exception) {
            $this->assertEquals(count($event->groups), 1);
            $this->assertEquals(count($group->events), 1);
            return;
        }

        $this->fail('A group cannot be registered two times to an event');
    }

    /** @test */
    function can_determine_if_logged_user_is_subscribed_to_event_of_type_individual()
    {
        seed_database();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',2)->first();
        $event->inscribeUser($user);
        $event = Event::find($event->id);
        $this->assertTrue($event->inscribed);
    }

    /** @test */
    function can_determine_if_logged_user_is_no_subscribed_to_event_of_type_individual()
    {
        seed_database();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',2)->first();
        $this->assertFalse($event->inscribed);
    }

    /** @test */
    function can_determine_if_logged_user_is_subscribed_to_event_of_type_groupal()
    {
        seed_database();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->first();
        $group = factory(Group::class)->create([
            'name' => 'Smells Like Team Spirit'
        ]);
        $group->add($user);
        $event->inscribeGroup($group);
        $event = Event::find($event->id);
        $this->assertTrue($event->inscribed);
    }

    /** @test */
    function can_determine_if_logged_user_is_no_subscribed_to_event_of_type_groupal()
    {
        seed_database();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->first();
        $group = factory(Group::class)->create([
            'name' => 'Smells Like Team Spirit'
        ]);
        $group->add($user);
        $event = Event::find($event->id);
        $this->assertFalse($event->inscribed);
    }

    /** @test */
    public function can_unregister_users()
    {
        seed_database();
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',2)->get()->first();
        $user = factory(User::class)->create();
        $event->inscribeUser($user);
        $event = $event->fresh();

        $event->unregisterUser($user);
        $event = $event->fresh();
        $this->assertCount(0,$event->users);
        $this->assertCount(0,$user->events);
    }

    /** @test */
    public function cannot_unregister_users_to_events_of_type_groupal()
    {
        seed_database();
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->first();
        $user = factory(User::class)->create();
        try {
            $event->inscribeUser($user);
        } catch (InscriptionException $exception) {
            $this->assertEquals(count($event->users), 0);
            $this->assertEquals(count($user->events), 0);
            return;
        }

        $this->fail('An user cannot be unregistered to an event of type groupal');
    }

    /** @test */
    public function can_check_if_an_event_has_an_specific_user_as_participant()
    {
        seed_database();
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',2)->first();
        $user = factory(User::class)->create();
        $this->assertFalse($event->hasParticipant($user));

        $event->inscribeUser($user);
        $event = $event->fresh();

        $this->assertTrue($event->hasParticipant($user));

        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->first();

        $user = factory(User::class)->create();
        $group = factory(Group::class)->create([
            'name' => 'Smells like team spirit'
        ]);

        $this->assertFalse($event->hasParticipant($user));
        $group->add($user);

        $event->inscribeGroup($group);
        $event = $event->fresh();

        $this->assertTrue($event->hasParticipant($user));
    }

    /** @test */
    function can_determine_if_logged_user_is_leader_of_group_inscribed_to_event_of_type_groupal()
    {
        seed_database();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->first();
        $group = factory(Group::class)->create([
            'name' => 'Smells Like Team Spirit'
        ]);
        $group->add($user);
        $this->assertFalse($event->leading);
        $event->inscribeGroup($group);
        $event = Event::find($event->id);
        $this->assertTrue($event->leading);
    }

    /** @test */
    public function can_unregister_groups()
    {
        seed_database();
        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->first();

        $group = factory(Group::class)->create();
        $event->inscribeGroup($group);
        $event = $event->fresh();

        $this->assertEquals($event->groups->first()->id, $group->id);
        $this->assertEquals($group->events->first()->id, $event->id);

        $event->unregisterGroup($group);
        $event = $event->fresh();
        $group = $group->fresh();
        $this->assertFalse(in_array($group->id, $event->groups->pluck('id')->all()));
        $this->assertFalse(in_array($event->id, $group->events->pluck('id')->all()));

    }

}
