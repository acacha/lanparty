<?php

namespace Tests\Feature;

use App\Facades\InvitationCode;
use App\Invitation;
use App\InvitationCodeGeneratorComplex;
use App\InvitationCodeGeneratorSimple;
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

//        Mail::fake()

//        Artisan::command()
//        Event::dispatch()
//        Auth::user()
        //Crypt::hash()
//        DB::table
        //Log:::debug();

//        Redirect  -> redirect()

        // Indicar al sistema quin InvitationCode generator utilitzar per al test
        // Mocking Vull modificar el objecte real (serà segons la config) per un de mentida. un mock
//        InvitationCodeGenerator::

//        $generator = Mockery::mock('App\InvitationCodeGeneratorSimple[generate]');
//
//        $generator->shouldReceive('generate')
//            ->andReturn('INVITATIONCODE_123');

        //        app()->bind(InvitationCodeGenerator::class, function() use ($generator)  {
//                return $generator;
//        });

        InvitationCode::shouldReceive('generate')
            ->andReturn('INVITATIONCODE_123');

        // 2 Execució
        $this->artisan('invite-manager', [
            'email' => 'pepitolospalotes@gmail.com'
        ]);

        //Invitation: email, code
        // 3 asserts
        $invitation = Invitation::first();
        $this->assertEquals('pepitolospalotes@gmail.com', $invitation->email);
        $this->assertEquals('INVITATIONCODE_123', $invitation->code);

        //assertDatabaseHas


        //Comprovar s'ha enviat email
        // Mail::assertSent
    }
}
