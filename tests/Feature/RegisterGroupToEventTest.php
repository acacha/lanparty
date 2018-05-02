<?php

namespace Tests\Feature;

use App\Event;
use App\Group;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class RegisterGroupToEventTest.
 *
 * @package Tests\Feature
 */
class RegisterGroupToEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function logged_user_can_register_group_to_event_as_leader()
    {
        seed_database();
        Storage::fake('local');

        $leader = factory(User::class)->create([
            'name' => 'Pepe Pardo Jeans',
            'email' => 'pepepardo@jeans.com',
            'givenName' => 'Pepe',
            'sn1' => 'Pardo',
            'sn2' => 'Jeans'
        ]);
        $this->actingAs($leader,'api');
        $event = Event::inRandomOrder()->where('inscription_type_id',1)->first();

        $member1 = factory(User::class)->create(
            [
                'name' => 'Pepa Parda Jeans',
                'email' => 'pepaparda@jeans.com',
                'givenName' => 'Pepa',
                'sn1' => 'Parda',
                'sn2' => 'Jeans'
        ]);
        $member2 = factory(User::class)->create();
        $member3 = factory(User::class)->create();
        $member4 = factory(User::class)->create();

        $members = collect([$member1, $member2, $member3, $member4]);
        $ids = $members->pluck('id')->toArray();

        $group = null;
        try {
            $group = Group::findByName('Smells Like Team Spirit');
        } catch (ModelNotFoundException $e) {
            $this->assertEquals(null, $group);
        }

        $file = File::image('avatar.png');

        $response = $this->json('POST','/api/v1/events/' . $event->id . '/register_group', [
            'name' => 'Smells Like Team Spirit',
            'avatar' => $file,
            'ids' => $ids
        ]);

        // ASSERTS
        $response->assertSuccessful();

//        $response->dump();

        $response->assertJsonStructure([
            'id',
            'name',
            'avatar',
            'members',
            'leader'
        ]);
        $response->assertJson([
            'id' => 1,
            'name' => 'Smells Like Team Spirit',
            'avatar' => 'avatars/group_1_avatar.png',
            'leader' => [
              'id' => 1,
              'name' => 'Pepe Pardo Jeans',
              'email' => 'pepepardo@jeans.com',
              'givenName' => 'Pepe',
              'sn1' => 'Pardo',
              'sn2' => 'Jeans'
            ]
        ]);
        $response->assertJsonFragment([
                'id' => 2,
                'name' => 'Pepa Parda Jeans',
                'email' => 'pepaparda@jeans.com',
                'givenName' => 'Pepa',
                'sn1' => 'Parda',
                'sn2' => 'Jeans'
        ]);

        $group = Group::findByName('Smells Like Team Spirit');
        $this->assertInstanceOf(Group::class, $group);

        $this->assertEquals('avatars/group_' . $group->id . '_avatar.png',$group->avatar);

        $this->assertFileEquals(
            $file->getPathname(),
            Storage::disk('local')->path($group->avatar)
        );

        Storage::disk('local')->assertExists($group->avatar);

        $this->assertCount(5, $group->members);
        $this->assertCount(0, $group->members->pluck('id')->diff(collect(array_merge([$leader->id], $ids))));

        // No limits in how many members a group could have in DATABASE -> Lanparty User interface manage that
        // depending on event type

        $this->assertTrue($group->leader->is($leader));
        $this->assertTrue($event->hasParticipant($leader));
        $this->assertTrue($group->getMemberByOrder(1)->is($leader));

        $event = $event->fresh();
        $group = $group->fresh();
        $i=2;
        foreach ($members as $member) {
            $this->assertTrue($event->hasParticipant($member));
            $this->assertTrue($group->getMemberByOrder($i)->is($member));
            $i++;
        }

        $group2leader = factory(User::class)->create();
        $this->actingAs($group2leader,'api');

        $group2Member1 = factory(User::class)->create();
        $group2Member2 = factory(User::class)->create();
        $group2Member3 = factory(User::class)->create();
        $group2Member4 = factory(User::class)->create();

        $group2Members = collect([$group2Member1, $group2Member2, $group2Member3, $group2Member4]);
        $group2Ids = $group2Members->pluck('id')->toArray();

        $file2 = File::image('avatar2.png');

        $response = $this->json('POST','/api/v1/events/' . $event->id . '/register_group', [
            'name' => 'Not Fast, Just Furios',
            'avatar' => $file2,
            'ids' => $group2Ids
        ]);

        $response->assertSuccessful();
        $group2 = Group::findByName('Not Fast, Just Furios');
        $this->assertInstanceOf(Group::class, $group2);

        $this->assertEquals('avatars/group_' . $group2->id . '_avatar.png',$group2->avatar);

        $this->assertFileEquals(
            $file->getPathname(),
            Storage::disk('local')->path($group2->avatar)
        );

        Storage::disk('local')->assertExists($group2->avatar);

        $this->assertCount(5, $group2->members);
        $this->assertCount(0, $group2->members->pluck('id')->diff(collect(array_merge([$group2leader->id], $group2Ids))));

        $this->assertTrue($group2->leader->is($group2leader));
        $event = $event->fresh();
        $group2 = $group2->fresh();
        $this->assertTrue($event->hasParticipant($group2leader));

        //TODO ORDER NOT WORKING
        $this->assertTrue($group2->getMemberByOrder(1)->is($group2leader));

        $i=2;
        foreach ($group2Members as $member) {
            $this->assertTrue($event->hasParticipant($member));
            $this->assertTrue($group2->getMemberByOrder($i)->is($member));
            $i++;
        }


    }

    /** @test */
    public function register_group_to_event_as_leader_test_validation()
    {

        seed_database();
        $participant = factory(User::class)->create();
        $this->actingAs($participant,'api');
        $event = Event::inRandomOrder()->where('inscription_type_id',1)->first();
        $response = $this->json('POST','/api/v1/events/' . $event->id . '/register_group');
        $response->assertStatus(422);
        $content = json_decode($response->getContent());

        $this->assertEquals('The given data was invalid.', $content->message);
        $this->assertEquals('El camp nom és obligatori.', $content->errors->name[0]);
        $this->assertEquals('El camp ids és obligatori.', $content->errors->ids[0]);
        $this->assertEquals('El camp avatar és obligatori.', $content->errors->avatar[0]);

//        $this->withoutExceptionHandling();

        $event = Event::inRandomOrder()->where('inscription_type_id',1)->first();
        $response = $this->json('POST','/api/v1/events/' . $event->id . '/register_group',[
            'name' => 'Smells Like Team Spirit',
            'avatar' => 'asdsd',
            'ids' => [1,2,3]
        ]);
        $response->assertStatus(422);
        $content = json_decode($response->getContent());

        $this->assertEquals('The given data was invalid.', $content->message);
        $this->assertEquals('avatar ha de ser una imatge.', $content->errors->avatar[0]);
    }

    /** @test */
    public function logged_user_cannot_register_group_to_event_as_leader_if_event_is_individual()
    {
//        $this->withoutExceptionHandling();
        seed_database();

        $participant = factory(User::class)->create();
        $this->actingAs($participant,'api');
        $event = Event::inRandomOrder()->where('inscription_type_id',1)->first();

        $leader = factory(User::class)->create();
        $this->actingAs($leader,'api');

        $response = $this->json('POST','/api/v1/events/' . $event->id . '/register_group');

        $response->assertStatus(422);
//        $response->dump();
    }

    /** @test */
    public function leader_user_can_unregister_group_to_event()
    {
        $this->withoutExceptionHandling();
        seed_database();

        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->first();
        $leader = factory(User::class)->create();

        $group = factory(Group::class)->create();
        $group->add($leader);
        $event->registerGroup($group);
        $event = $event->fresh();
        $tickets = $event->tickets;

        $this->assertTrue($event->hasGroup($group));

        $this->actingAs($leader,'api');

        $response = $this->json('DELETE','/api/v1/events/' . $event->id . '/register_group/' . $group->id);

        $response->assertSuccessful();
        $event = $event->fresh();
        $this->assertFalse($event->hasGroup($group));
        $group = $group->fresh();
        $this->assertNull($group);

        $this->assertEquals($event->tickets, $tickets);

    }

    /** @test */
    public function admin_user_can_unregister_group_to_event()
    {
        $this->withoutExceptionHandling();
        seed_database();

        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->first();
        $manager = factory(User::class)->create();
        $manager->assignRole('Manager');

        $group = factory(Group::class)->create();
        $event->registerGroup($group);
        $event = $event->fresh();
        $this->assertTrue($event->hasGroup($group));

        $this->actingAs($manager,'api');

        $response = $this->json('DELETE','/api/v1/events/' . $event->id . '/register_group/' . $group->id);

        $response->assertSuccessful();
        $event = $event->fresh();
        $this->assertFalse($event->hasGroup($group));
        $group = $group->fresh();
        $this->assertNull($group);
    }

    /** @test */
    public function regular_user_cannot_unregister_group_to_event()
    {
        seed_database();

        $event = Event::published()->inRandomOrder()->where('inscription_type_id',1)->first();
        $regularuser = factory(User::class)->create();

        $group = factory(Group::class)->create();
        $event->registerGroup($group);
        $event = $event->fresh();
        $this->assertTrue($event->hasGroup($group));

        $this->actingAs($regularuser,'api');

        $response = $this->json('DELETE','/api/v1/events/' . $event->id . '/register_group/' . $group->id);

        $response->assertStatus(403);
        $event = $event->fresh();
        $this->assertTrue($event->hasGroup($group));
    }

    /** @todo */
    public function leader_can_update_members_order()
    {
        // TODO
        // TESTING SORT
    }
}

