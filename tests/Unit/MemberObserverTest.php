<?php

namespace Tests\Unit;

use App\Group;
use App\Member;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class MemberObserverTest.
 *
 * @package Tests\Unit
 *
 */
class MemberObserverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function members_are_sorted()
    {
        $group = factory(Group::class)->create();
        $leader = factory(User::class)->create();
        $member = Member::create([
            'user_id' => $leader->id,
            'group_id' => $group->id
        ]);

        $this->assertEquals($member->order,1);

        $teamMember1 = factory(User::class)->create();
        $member = Member::create([
            'user_id' => $teamMember1->id,
            'group_id' => $group->id
        ]);

        $this->assertEquals($member->order,2);

        $teamMember2 = factory(User::class)->create();
        $member = Member::create([
            'user_id' => $teamMember2->id,
            'group_id' => $group->id
        ]);

        $this->assertEquals($member->order,3);

        $leader2 = factory(User::class)->create();
        $group2 = factory(Group::class)->create();
        $member = Member::create([
            'user_id' => $leader2->id,
            'group_id' => $group2->id
        ]);

        $this->assertEquals($member->order,1);

        $group2Member1 = factory(User::class)->create();
        $member = Member::create([
            'user_id' => $group2Member1->id,
            'group_id' => $group2->id
        ]);

        $this->assertEquals($member->order,2);
    }
}
