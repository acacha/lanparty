<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Event.
 *
 * @package App
 */
class Event extends Model
{
    protected $guarded = [];

    /**
     * Register user to event.
     *
     * @param User $user
     */
    public function registerUser(User $user)
    {
       $this->users()->save($user);
    }

    /**
     * Get all of the users that are registered to this event.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'registration');
    }

    /**
     * Get all of the groups that are registered to the event.
     */
    public function groups()
    {
        // return $this->morphedByMany(Group::class, 'registration');
    }
}
