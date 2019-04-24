<?php

namespace Tests\Feature\Api;

use App\User;
use Spatie\Permission\Models\Role;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ManagersControllerTest.
 *
 * @package Tests\Feature
 */
class ManagersControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /** @test */
    public function manager_can_list_managers()
    {
        $this->loginAsManager('api');
        $response = $this->json('GET','/api/v1/managers');
        $response->assertSuccessful();
        $result= json_decode($response->getContent());
        $this->assertCount(1,$result);

        $user = factory(User::class)->create();
        $user->assignRole('Manager');
        $response = $this->json('GET','/api/v1/managers');
        $response->assertSuccessful();
        $result= json_decode($response->getContent());
        $this->assertCount(2,$result);
    }

    /** @test */
    public function regular_user_cannot_list_managers()
    {
        $this->login('api');
        $response = $this->json('GET','/api/v1/managers');
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_user_cannot_list_managers()
    {
        $response = $this->json('GET','/api/v1/managers');
        $response->assertStatus(401);
    }
}
