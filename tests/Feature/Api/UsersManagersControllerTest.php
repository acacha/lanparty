<?php

namespace Tests\Feature\Api;

use App\User;
use Spatie\Permission\Models\Role;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class UsersManagersControllerTest.
 *
 * @package Tests\Feature
 */
class UsersManagersControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /** @test */
    public function manager_can_unassign_role_manager_to_user()
    {
        $this->loginAsManager('api');
        $user = User::create([
            'name' => 'Pepe Pardo Jeans',
            'givenName' => 'Pepe',
            'sn1' => 'Pardo',
            'sn2' => 'Jeans',
        ]);
        $user->assignRole('Manager');
        $this->assertTrue($user->isManager());
        $response = $this->json('DELETE','/api/v1/user/' . $user->id . '/manager');
        $response->assertSuccessful();
        $user= $user->fresh();
        $this->assertFalse($user->isManager());
    }

    /** @test */
    public function regular_user_cannot_unassign_role_manager_to_user()
    {
        $this->login('api');
        $user = User::create([
            'name' => 'Pepe Pardo Jeans',
            'givenName' => 'Pepe',
            'sn1' => 'Pardo',
            'sn2' => 'Jeans',
        ]);
        $response = $this->json('DELETE','/api/v1/user/' . $user->id . '/manager');
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_user_cannot_unassign_role_manager_to_user()
    {
        $user = User::create([
            'name' => 'Pepe Pardo Jeans',
            'givenName' => 'Pepe',
            'sn1' => 'Pardo',
            'sn2' => 'Jeans',
        ]);
        $response = $this->json('DELETE','/api/v1/user/' . $user->id . '/manager');
        $response->assertStatus(401);
    }

}
