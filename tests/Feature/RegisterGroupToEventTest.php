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
//        $this->withoutExceptionHandling();
        seed_database();
        Storage::fake('local');

        $leader = factory(User::class)->create();
        $this->actingAs($leader,'api');
        $event = Event::inRandomOrder()->where('inscription_type_id',1)->first();

        $member1 = factory(User::class)->create();
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
            return;
        }

        $file = File::image('avatar.png');

        $response = $this->json('POST','/api/v1/events/' . $event->id . '/register_group', [
            'name' => 'Smells Like Team Spirit',
            'avatar' => $file,
//            'leader' Not needed -> Logged user is Group leader
            'ids' => $ids
        ]);

        // ASSERTS
        $response->assertSuccessful();
        $group = Group::findByName('Smells Like Team Spirit');
        $this->assertInstanceOf(Group::class, $group);
        $this->assertNotNull($group->avatar);
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

    }

    /** @test */
    public function logged_user_cannot_register_group_to_event_as_leader_if_event_is_individual()
    {
        seed_database();

        $participant = factory(User::class)->create();
        $this->actingAs($participant,'api');
        $event = Event::inRandomOrder()->where('inscription_type_id',2)->first();

        $response = $this->post('/api/v1/events/' . $event->id . '/register_group');

        $response->assertStatus(422);
    }

    /** @todo */
    public function leader_can_update_members_order()
    {
        // TESTING SORT
    }
}
