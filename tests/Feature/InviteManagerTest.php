<?php

namespace Tests\Feature;

use App\Facades\InvitationCode;
use App\Invitation;
use App\InvitationCodeGeneratorComplex;
use App\InvitationCodeGeneratorSimple;
use App\Mail\ManagerInvitationEmail;
use Mail;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class InviteManagerTest.
 *
 * @package Tests\Feature
 *
 */
class InviteManagerTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function invite_manager_via_cli()
    {
        Mail::fake();

        InvitationCode::shouldReceive('generate')
            ->andReturn('INVITATIONCODE_123');

        $this->artisan('invite-manager', [
            'email' => 'pepitolospalotes@gmail.com'
        ]);
        $invitation = Invitation::first();
        $this->assertEquals('pepitolospalotes@gmail.com', $invitation->email);
        $this->assertEquals('INVITATIONCODE_123', $invitation->code);

        Mail::assertSent(ManagerInvitationEmail::class, function ($mail) use ($invitation) {
            return $mail->hasTo('pepitolospalotes@gmail.com')
                && $mail->invitation->is($invitation);
        });
    }
}
