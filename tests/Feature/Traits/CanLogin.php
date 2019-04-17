<?php

namespace Tests\Feature\Traits;

use App\User;
use Spatie\Permission\Models\Permission;
use App\Role as LanPartyRole;

/**
 * Trait CanLogin
 * @package Tests\Feature\Traits
 */
trait CanLogin
{
    /**
     * @param null $guard
     * @return mixed
     */
    protected function login($guard = null)
    {
        $user = factory(User::class)->create();
        $this->actingAs($user,$guard);
        return $user;
    }

    /**
     * @param null $guard
     * @return mixed
     */
    protected function loginAsUsingRole($guard,$role)
    {
        $user = factory(User::class)->create();

        $roles = is_array($role) ? $role : [$role];

        foreach ($roles as $role) {
            $user->assignRole($role);
        }
        $this->actingAs($user,$guard);
        return $user;
    }

    public function loginAsManager($guard = 'web')
    {
        initialize_manager_role();
        return $this->loginAsUsingRole($guard, LanPartyRole::MANAGER['name']);
    }

    /**
     * @param null $guard
     * @return mixed
     */
    protected function loginWithPermission($guard,$permission)
    {
        $user = factory(User::class)->create();
        Permission::create([
            'name' => $permission
        ]);
        $user->givePermissionTo($permission);
        $this->actingAs($user,$guard);
        return $user;
    }

    protected function loginAsSuperAdmin($guard = null)
    {
        $user = factory(User::class)->create();
        $user->admin = true;
        $user->save();
        $user = $user->fresh();
        $this->actingAs($user,$guard);
        return $user;
    }
}
