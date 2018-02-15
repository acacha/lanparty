<?php

namespace App;

use App\Exceptions\InscriptionException;
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

    public $with = ['users','groups'];


    /**
     * Register user to event.
     *
     * @param User $user
     */
    public function registerUser(User $user)
    {
        if ($this->inscription_type_id == 1) throw new InscriptionException;
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
     * Register group to event
     */
    public function registerGroup(Group $group)
    {
        if ($this->inscription_type_id == 2) throw new InscriptionException;
        $this->groups()->save($group);
    }

    /**
     * Alias for registerGroup.
     * s
     * @param Group $group
     */
    public function inscribeGroup(Group $group)
    {
        $this->registerGroup($group);
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
        return $this->morphedByMany(Group::class, 'registration')->orderBy('name');
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
