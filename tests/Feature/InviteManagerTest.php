<?php

namespace Tests\Feature;

use App\Invitation;
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
        // 1 2 3

//        Mail::fake()

//        Artisan::command()
//        Event::dispatch()
//        Auth::user()
        //Crypt::hash()
//        DB::table
        //Log:::debug();

//        Redirect  -> redirect()

        $this->artisan('invite-manager', [
            'email' => 'pepitolospalotes@gmail.com'
        ]);

        //Invitation: email, code

        $invitation = Invitation::first();
        $this->assertEquals('pepitolospalotes@gmail.com', $invitation->email);
        $this->assertEquals('INVITATIONCODE_123', $invitation->code);

        //assertDatabaseHas


        //Comprovar s'ha enviat email
        // Mail::assertSent
    }
}
