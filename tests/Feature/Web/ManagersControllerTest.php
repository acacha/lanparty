<?php

namespace Tests\Feature\web;

use App\Role;
use App\User;
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
    public function manager_can_see_managers_module()
    {
        $this->loginAsManager('web');
        $response = $this->get('/manage/managers');
        $response->assertSuccessful();
        $response->assertViewIs('manage.managers.index');
        $response->assertViewHas('managers');
    }

    /** @test */
    public function manager_can_see_managers_module_with_some_managers()
    {
        $manager = Role::create([
            'name' => 'Manager'
        ]);
        $user = factory(User::class)->create([
            'name' => 'Pepe Pardo Jeans',
            'email' => 'pepepardojeans@gmail.com'
        ]);
        $user->assignRole($manager);
        $this->loginAsManager('web');
        $response = $this->get('/manage/managers');
        $response->assertSuccessful();
        $response->assertViewIs('manage.managers.index');
        $response->assertViewHas('managers', function ($managers) {
            return is_array($managers->toArray()) && count($managers) === 2;
        });
    }

    /** @test */
    public function superadmin_can_see_managers_module()
    {
        $this->loginAsSuperAdmin('web');
        $response = $this->get('/manage/managers');
        $response->assertSuccessful();
        $response->assertViewIs('manage.managers.index');
        $response->assertViewHas('managers');
    }

    /** @test */
    public function regular_user_cannot_see_managers_module()
    {
        $this->login('web');
        $response = $this->get('/manage/managers');
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_user_cannot_see_managers_module()
    {
        $response = $this->get('/manage/managers');
        $response->assertRedirect('/login');
    }

}
