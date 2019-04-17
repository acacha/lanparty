<?php

namespace Tests\Feature;

use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class AcceptInvitationTest.
 *
 * @package Tests\Feature
 */
class SendInvitationToManagerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /** @test */
    function manager_can_send_invitation_to_user_to_be_manager()
    {
        $this->loginAsManager('api');
        $email = 'pepepardo@jeans.com';
        $response = $this->json('POST','/api/v1/manage/managers/send_invitation/', [
            'email' => $email
        ]);
        $response->assertSuccessful();
    }

    /** @test */
    function manager_can_send_invitation_to_user_to_be_manager_validation()
    {
        $this->loginAsManager('api');
        $response = $this->json('POST','/api/v1/manage/managers/send_invitation/');
        $response->assertStatus(422);
    }

    /** @test */
    function regular_user_cannot_send_invitation_to_user_to_be_manager()
    {
        $this->login('api');
        $response = $this->post('/api/v1/manage/managers/send_invitation/');
        $response->assertStatus(403);
    }

    /** @test */
    function guest_user_cannot_send_invitation_to_user_to_be_manager()
    {
        $response = $this->json('POST','/api/v1/manage/managers/send_invitation/');
        $response->assertStatus(401);
    }

}
