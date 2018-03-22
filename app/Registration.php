<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Registration.
 *
 * @package App
 */
class Registration extends Model
{
    protected $guarded = [];

    /**
     * Available scope.
     *
     * @param $query
     * @return mixed
     */
    public function scopeAvailable($query)
    {
        return $query->whereNull('registration_id');
    }

    /**
     * Assigned scope.
     *
     * @param $query
     * @return mixed
     */
    public function scopeAssigned($query)
    {
        return $query->whereNotNull('registration_id');
    }

    /**
     * By type.
     *
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('registration_type',$type);
    }

    /**
     * Group.
     *
     * @param $query
     * @param Group $group
     * @return mixed
     */
    public function scopeGroup($query, Group $group)
    {
        return $query->where('registration_type',Group::class)->where('registration_id', $group->id);
    }

    /**
     * User.
     *
     * @param $query
     * @param User $user
     * @return mixed
     */
    public function scopeUser($query, User $user)
    {
        return $query->where('registration_type',User::class)->where('registration_id', $user->id);
    }
}
