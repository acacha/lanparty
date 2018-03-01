<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Invitation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class AcceptInvitationTest.
 *
 * @package Tests\Feature
 */
class AcceptInvitationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function viewing_an_unused_invitation()
    {
        initialize_roles();
        $user = factory(User::class)->create();
        $this->assertFalse($user->hasRole('manager'));
        $this->actingAs($user);
        $this->withoutExceptionHandling();

        $invitation = factory(Invitation::class)->create([
            'code' => 'TESTCODE1234'
        ]);

        $response = $this->get('/manage/invitations/TESTCODE1234');

        $this->assertTrue($invitation->fresh()->hasBeenUsed());
        $this->assertTrue($user->fresh()->hasRole('Manager'));

        $response->assertRedirect('/manage/participants');
        $response->assertSessionHas('flash','Ok! Has utilitzat la teva invitació. Ara ets un usuari amb rol Manager');
    }

    /** @test */
    function viewing_a_used_invitation()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        factory(Invitation::class)->create([
            'user_id' => factory(User::class)->create(),
            'code' => 'TESTCODE1234',
        ]);

        $response = $this->get('/manage/invitations/TESTCODE1234');

        $response->assertStatus(404);
    }

    /** @test */
    function viewing_an_invitation_that_does_not_exist()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->get('/manage/invitations/TESTCODE1234');

        $response->assertStatus(404);
    }

}
