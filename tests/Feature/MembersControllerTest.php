<?php

namespace Tests\Feature;

use App\Group;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class MembersControllerTest.
 *
 * @package Tests\Feature
 */
class MembersControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function logged_user_can_leave_a_group()
    {
        $this->withoutExceptionHandling();
        $participant = factory(User::class)->create();
        $this->actingAs($participant,'api');
        $group = factory(Group::class)->create();
        $group->add($participant);
        $group = $group->fresh();
        $this->assertTrue($group->hasMember($participant));

        $response = $this->json('DELETE','/api/v1/group/' . $group->id . '/member');

        $response->assertSuccessful();
        $group = $group->fresh();
        $this->assertFalse($group->hasMember($participant));

    }
}
