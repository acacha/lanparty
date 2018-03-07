<?php

namespace Tests\Unit;

use App\Exceptions\UserAlreadyInscribedException;
use App\Exceptions\UserAlreadyMemberOfGroup;
use App\Group;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class GroupTest.
 *
 * @package Tests\Unit
 */
class GroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_find_group_by_name()
    {
        $group = factory(Group::class)->create([
            'name' => 'Smells Like Team Spirit'
        ]);
        $foundGroup = Group::findByName('Smells Like Team Spirit');

        $this->assertTrue($foundGroup->is($group));
    }

    /** @test */
    public function cannot_find_group_by_name()
    {
        $group = null;
        try {
            $group = Group::findByName('Smells Like Team Spirit');
            $this->assertEquals(null, $group);
        } catch (ModelNotFoundException $e) {
            $this->assertEquals(null, $group);
            return;
        }
        $this->fail("Finding a not existing group name not throws ModelNotFoundException.");
    }

    /** @test */
    public function can_get_group_leader()
    {
        $group = factory(Group::class)->create([
            'name' => 'Smells Like Team Spirit'
        ]);

        $this->assertEquals(null, $group->leader);

        $leader = factory(User::class)->create();
        $group->members()->save($leader, ['order' => 1]);

        $this->assertTrue($group->leader->is($leader));
    }

    /** @test */
    public function can_add_user_to_group()
    {
        $group = factory(Group::class)->create([
            'name' => 'Smells Like Team Spirit'
        ]);

        $this->assertCount(0, $group->members);

        $leader = factory(User::class)->create();
        $group->add($leader);

        $group = $group->fresh();
        $this->assertCount(1, $group->members);
        $this->assertTrue($group->leader->is($leader));

        $participant1 = factory(User::class)->create();
        $group->add($participant1);
        $group = $group->fresh();
        $this->assertCount(2, $group->members);
        $this->assertFalse($group->leader->is($participant1));
    }

    /** @test */
    public function cannnot_add_an_existing_user_to_group()
    {
        $group = factory(Group::class)->create([
            'name' => 'Smells Like Team Spirit'
        ]);

        $this->assertCount(0, $group->members);

        $leader = factory(User::class)->create();
        $group->add($leader);

        $group = $group->fresh();
        $this->assertCount(1, $group->members);
        $this->assertTrue($group->leader->is($leader));

        try {
            $group->add($leader);
        } catch(UserAlreadyMemberOfGroup $e) {
            $this->assertCount(1, $group->members);
            return;
        }

        $this->fails('An already member of a group user cannot added to group');


    }

    /** @test */
    public function can_check_if_group_has_user_as_member()
    {
        $group = factory(Group::class)->create([
            'name' => 'Smells Like Team Spirit'
        ]);
        $leader = factory(User::class)->create();
        $this->assertFalse($group->hasMember($leader));

        $group->add($leader);
        $group = $group->fresh();
        $this->assertTrue($group->hasMember($leader));
    }

    /** @test */
    public function can_get_member_by_order()
    {
        $group = factory(Group::class)->create([
            'name' => 'Smells Like Team Spirit'
        ]);

        $this->assertEquals(null, $group->getMemberByOrder(1));

        $leader = factory(User::class)->create();
        $group->add($leader);
        $group = $group->fresh();
        $this->assertTrue($group->getMemberByOrder(1)->is($leader));

        $participant1 = factory(User::class)->create();
        $group->add($participant1);
        $group = $group->fresh();
        $this->assertTrue($group->getMemberByOrder(2)->is($participant1));

        $participant2 = factory(User::class)->create();
        $group->add($participant2);
        $group = $group->fresh();
        $this->assertTrue($group->getMemberByOrder(3)->is($participant2));
    }

    /** @test */
    public function user_can_leave_a_group()
    {
        $group = factory(Group::class)->create([
            'name' => 'Smells Like Team Spirit'
        ]);

        $this->assertCount(0, $group->members);

        $leader = factory(User::class)->create();
        $group->add($leader);

        $group = $group->fresh();
        $this->assertCount(1, $group->members);
        $this->assertTrue($group->leader->is($leader));

        $group->leave($leader);
        $group = $group->fresh();
        $this->assertCount(0, $group->members);
        $this->assertNull($group->leader);
    }
}
