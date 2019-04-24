<?php

namespace Tests\Feature\web;

use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class UsersControllerTest.
 *
 * @package Tests\Feature
 */
class UsersControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /** @test */
    public function manager_can_see_users_module()
    {
        $this->withoutExceptionHandling();
        $this->loginAsManager('web');
        $response = $this->get('/manage/users');
        $response->assertSuccessful();
        $response->assertViewIs('manage.users.index');
        $response->assertViewHas('users');
    }

//    /** @test */
//    public function manager_can_see_managers_module_with_some_managers()
//    {
//        $manager = Role::create([
//            'name' => 'Manager'
//        ]);
//        $user = factory(User::class)->create([
//            'name' => 'Pepe Pardo Jeans',
//            'email' => 'pepepardojeans@gmail.com'
//        ]);
//        $user->assignRole($manager);
//        $this->loginAsManager('web');
//        $response = $this->get('/manage/managers');
//        $response->assertSuccessful();
//        $response->assertViewIs('manage.managers.index');
//        $response->assertViewHas('managers', function ($managers) {
//            return is_array($managers->toArray()) && count($managers) === 2;
//        });
//    }
//
//    /** @test */
//    public function superadmin_can_see_managers_module()
//    {
//        $this->loginAsSuperAdmin('web');
//        $response = $this->get('/manage/managers');
//        $response->assertSuccessful();
//        $response->assertViewIs('manage.managers.index');
//        $response->assertViewHas('managers');
//    }
//
//    /** @test */
//    public function regular_user_cannot_see_managers_module()
//    {
//        $this->login('web');
//        $response = $this->get('/manage/managers');
//        $response->assertStatus(403);
//    }
//
//    /** @test */
//    public function guest_user_cannot_see_managers_module()
//    {
//        $response = $this->get('/manage/managers');
//        $response->assertRedirect('/login');
//    }

}
