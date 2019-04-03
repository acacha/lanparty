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
class AcceptInvitationTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /** @test */
    function manager_can_send_invitation_to_user_to_be_manager()
    {
        $this->loginAsManager('api');
        $email = 'pepepardo@jeans.com';
        $response = $this->get('/api/v1/manage/managers/send_invitation/' . $email);
        $response->assertSuccessful();
    }

}
