<?php

namespace App;

use App\Exceptions\GroupAlreadyInscribedException;
use App\Exceptions\InscriptionException;
use App\Exceptions\NotEnoughTicketsException;
use App\Exceptions\UserAlreadyInscribedException;
use Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Event.
 *
 * @package App
 */
class Event extends Model
{
//    protected $appends = ['inscribed','tickets','available_tickets','assigned_tickets'];

    protected $guarded = [];

    /**
     * Add registrations (tickets available) for event
     *
     * @param $quantity
     * @return $this
     */
    public function addRegistrations($quantity)
    {
        foreach (range(1, $quantity) as $i) {
            $this->registrations()->create([]);
        }

        return $this;
    }

    /**
     * Alias for addRegistrations.
     *
     * @param $quantity
     * @return Event
     */
    public function addTickets($quantity)
    {
        return $this->addRegistrations($quantity);
    }

    /**
     * Tickets/registrations assigned to this event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Unregister user.
     *
     * @param $user
     */
    public function unregisterUser($user)
    {
        if ($this->inscription_type_id == 1) throw new InscriptionException('Cannot unregister an user in an event for groups');

        $this->users()->detach($user->id);

    }


    /**
     * Register user to event.
     *
     * @param User $user
     */
    public function registerUser(User $user)
    {
        if ($this->inscription_type_id == 1) throw new InscriptionException('Cannot register an user in an event for groups');
        if ($this->hasParticipant($user)) throw new UserAlreadyInscribedException;

        $tickets = $this->registrations()->available()->take(1)->get();

        if ($tickets->count() == 0) {
            throw new NotEnoughTicketsException;
        }

        $tickets->first()->update([
            'registration_type' => User::class,
            'registration_id' => $user->id
        ]);
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
     * Check if user is already registered to the event.
     *
     * @param User $user
     * @return bool
     */
    public function hasParticipant(User $user)
    {
        if ($this->published_at === null) return false;
        if ($this->inscription_type_id == 2) {
            return in_array($user->id, $this->users->pluck('id')->all());
        }
        foreach ($this->groups as $group) {
            if ($group->hasMember($user)) return true;
        }
        return false;
    }

    /**
     * Register group to event
     */
    public function registerGroup(Group $group)
    {
        if ($this->inscription_type_id == 2) throw new InscriptionException('Cannot register a group in an event for individuals');
        if ($this->groupAlreadyInscribed($group)) throw new GroupAlreadyInscribedException;
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
     * Check if group is already registered to the event.
     *
     * @param Group $group
     * @return bool
     */
    protected function groupAlreadyInscribed(Group $group)
    {
        return in_array($group->id, $this->groups->pluck('id')->all());
    }

    /**
     * Get all of the users that are registered to this event.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'registration')->withTimestamps()->orderBy('sn1');
    }

    /**
     * Get all of the groups that are registered to the event.
     */
    public function groups()
    {
        return $this->morphedByMany(Group::class, 'registration')->withTimestamps()->orderBy('name');
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

    /**
     * Get total number of tickets/registrations.
     *
     * @return string
     */
    public function getTicketsAttribute()
    {
        return count($this->registrations);
    }

    /**
     * Get available number of tickets/registrations.
     *
     * @return string
     */
    public function getAvailableTicketsAttribute()
    {
        return $this->registrations()->available()->get()->count();
    }

    /**
     * Get assigned number of tickets/registrations.
     *
     * @return string
     */
    public function getAssignedTicketsAttribute()
    {
        return $this->registrations()->assigned()->count();
    }

    /**
     * Published scope.
     *
     * @return string
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

}
