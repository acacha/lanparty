<?php

namespace Tests\Unit;

use App\Invitation;
use App\Mail\ManagerInvitationEmail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ManagerInvitationEmailTest.
 *
 * @package Tests\Unit
 */
class ManagerInvitationEmailTest extends TestCase
{
    /** @test */
    function email_contains_a_link_to_accept_the_invitation()
    {
        $invitation = factory(Invitation::class)->make([
            'email' => 'john@example.com',
            'code' => 'TESTCODE1234',
        ]);

        $email = new ManagerInvitationEmail($invitation);

        $this->assertStringContainsString(url('/manage/invitations/TESTCODE1234'), $email->render());
    }

    /** @test */
    function email_has_the_correct_subject()
    {
        $invitation = factory(Invitation::class)->make();

        $email = new ManagerInvitationEmail($invitation);

        $this->assertEquals("Invitació per ser gestor de l'aplicació de la LAN Party Institut de l'Ebre", $email->build()->subject);
    }
}
