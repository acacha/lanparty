<?php

namespace App;

use App\Exceptions\GroupAlreadyInscribedException;
use App\Exceptions\InscriptionException;
use App\Exceptions\NotEnoughTicketsException;
use App\Exceptions\UserAlreadyInscribedException;
use App\Traits\ApiURI;
use App\Traits\FormattedDates;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Event.
 *
 * @package App
 */
class Event extends Model
{
    use ApiURI, FormattedDates, SoftDeletes;

    protected $guarded = [];
    const DEFAULT_PHOTO = 'default.png';
//    const PHOTOS_PATH = 'user_photos';
    const DEFAULT_PHOTO_PATH = 'public/event_images/' . self::DEFAULT_PHOTO;

    public static function events()
    {
        return map_collection(Event::all());
    }

    public static function all_events()
    {
        return map_collection(Event::withTrashed()->get());
    }

    public static function published_events()
    {
        return map_collection(Event::published()->get());
    }

    /**
     * Add registrations (tickets available) for event
     *
     * @param $quantity
     * @return $this
     */
    public function addRegistrations($quantity)
    {
        foreach (range(1, $quantity) as $i) {
            $this->registrations()->create();
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
        $registration = $this->registrations()
            ->where('registration_type','=',\App\User::class)
            ->where('registration_id','=',$user->id)->first();
        $registration->registration_type = null;
        $registration->registration_id = null;
        $registration->save();
    }


    /**
     * Register user to event.
     * @param User $user
     */
    public function registerUser(User $user)
    {
        if ($this->inscription_type_id == 1) throw new InscriptionException('No es pot registrar un usuari a un esdeveniment per a grups');
        if ($this->published_at === null) throw new InscriptionException('No es pot registrar un usuari a un esdeveniment sense publicar');

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
     * Register group to event.
     *
     * @param Group $group
     */
    public function registerGroup(Group $group)
    {
        if ($this->inscription_type_id == 2) throw new InscriptionException('Cannot register a group in an event for individuals');
        if ($this->groupAlreadyInscribed($group)) throw new GroupAlreadyInscribedException;
        $this->groups()->save($group);
    }

    /**
     * Alias for registerGroup.
     *
     * @param Group $group
     */
    public function inscribeGroup(Group $group)
    {
        $this->registerGroup($group);
    }

    /**
     * Unregister group.
     *
     * @param Group $group
     */
    public function unregisterGroup(Group $group)
    {
        if ($this->inscription_type_id == 2) throw new InscriptionException('Cannot unregister a group in an event for individuals');

        $registration = $this->registrations()
            ->where('registration_type','=',\App\Group::class)
            ->where('registration_id','=',$group->id)->first();
        $registration->registration_type = null;
        $registration->registration_id = null;
        $registration->save();
    }

    /**
     * Check if group is already registered to the event.
     *
     * @param Group $group
     * @return bool
     */
    public function groupAlreadyInscribed(Group $group)
    {
        return in_array($group->id, $this->groups->pluck('id')->all());
    }

    /**
     * Alias for groupAlreadyInscribed.
     *
     * @param Group $group
     * @return bool
     */
    public function hasGroup(Group $group)
    {
        return $this->groupAlreadyInscribed($group);
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
        if (Auth::user()) {
            if ($this->inscription_type_id == 1) {
                foreach ($this->groups as $group) {
                    if ($group->members->pluck('id')->search(Auth::user()->id) !== false) return true;
                }
                return false;
            }
            return $this->users->pluck('id')->search(Auth::user()->id) === false ? false : true;
        }
        return false;
    }

    /**
     * Is current logged user leading a group inscribed to this event?.
     *
     * @return string
     */
    public function getLeadingAttribute()
    {
        if ($loggedUser = Auth::user()) {
            if ($this->inscription_type_id == 1) {
                foreach ($this->groups as $group) {
                    if (optional($group->members->first())->id === $loggedUser->id) return true;
                }
            }
        }
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
        return $this->registrations()->available()->count();
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
     * Active scope: same as published
     *
     * @return string
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('published_at');
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

    /**
     * Unpublished scope.
     *
     * @return string
     */
    public function scopeUnpublished($query)
    {
        return $query->whereNull('published_at');
    }

    public function map()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'session' => $this->session,
            'inscription_type_id' => $this->inscription_type_id,
            'image' => $this->image,
            'regulation' => $this->regulation,
            'participants_number' => (int) $this->participants_number,
            'api_uri' => $this->api_uri,
            'created_at' => $this->created_at,
            'created_at_timestamp' => $this->created_at_timestamp,
            'formatted_created_at' => $this->formatted_created_at,
            'formatted_created_at_diff' => $this->formatted_created_at_diff,
            'updated_at' => $this->updated_at,
            'updated_at_timestamp' => $this->updated_at_timestamp,
            'formatted_updated_at' => $this->formatted_updated_at,
            'formatted_updated_at_diff' => $this->formatted_updated_at_diff,
            'published_at' => $this->published_at,
            'deleted_at' => $this->deleted_at,
            'inscribed' => $this->inscribed,
            'tickets' => $this->tickets,
            'available_tickets' => $this->available_tickets,
            'assigned_tickets' => $this->assigned_tickets,
            'registrations' => $this->registrations,
        ];
    }

    public function mapSimple()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'inscription_type_id' => $this->inscription_type_id,
            'image' => $this->image,
            'regulation' => $this->regulation,
            'participants_number' => (int) $this->participants_number,
            'api_uri' => $this->api_uri,
            'created_at' => $this->created_at,
            'created_at_timestamp' => $this->created_at_timestamp,
            'formatted_created_at' => $this->formatted_created_at,
            'formatted_created_at_diff' => $this->formatted_created_at_diff,
            'updated_at' => $this->updated_at,
            'updated_at_timestamp' => $this->updated_at_timestamp,
            'formatted_updated_at' => $this->formatted_updated_at,
            'formatted_updated_at_diff' => $this->formatted_updated_at_diff,
            'inscribed' => $this->inscribed,
            'tickets' => $this->tickets,
            'available_tickets' => $this->available_tickets,
            'assigned_tickets' => $this->assigned_tickets,
            'registrations' => $this->registrations,
        ];
    }

}
