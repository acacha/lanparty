<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Event.
 *
 * @package App
 */
class Event extends Model
{
    protected $appends = ['inscribed'];

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
     * Alias for registerUser.
     *
     * @param User $user
     */
    public function inscribeUser(User $user)
    {
        $this->registerUser($user);
    }

    /**
     * Get all of the users that are registered to this event.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'registration')->orderBy('sn1');
    }

    /**
     * Get all of the groups that are registered to the event.
     */
    public function groups()
    {
        // return $this->morphedByMany(Group::class, 'registration');
    }

    /**
     * Is current logged user inscribed.
     *
     * @return string
     */
    public function getInscribedAttribute()
    {
        if (Auth::user()) return $this->users->pluck('id')->search(Auth::user()->id) === false ? false : true;
        return false;
    }
}
