<?php

namespace App;

use App\Exceptions\NotEnoughTicketsException;
use App\Http\Resources\NumberResource;
use App\Http\Resources\UserEventResource;
use App\Notifications\ResetPasswordNotification;
use App\Traits\FormattedDates;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User.
 *
 * @package App
 */
class User extends Authenticatable
{
    use HasApiTokens,Notifiable, HasRoles, FormattedDates;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'givenName', 'sn1', 'sn2'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function users()
    {
        return map_collection(User::all());
    }

    public function map()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'givenName' => $this->givenName,
            'sn1' => $this->sn1,
            'sn2' => $this->sn2,
            'formatted_created_at_date' => $this->formatted_created_at_date,
            'full_search' => $this->full_search,
            'inscription_paid' => $this->inscription_paid,
            'admin' => $this->admin,
            'manager' => $this->isManager(),
            'created_at' => $this->created_at,
            'created_at_timestamp' => $this->created_at_timestamp,
            'formatted_created_at' => $this->formatted_created_at,
            'formatted_created_at_diff' => $this->formatted_created_at_diff,
            'updated_at' => $this->updated_at,
            'formatted_updated_at' => $this->formatted_updated_at,
            'updated_at_timestamp' => $this->updated_at_timestamp,
            'formatted_updated_at_diff' => $this->formatted_updated_at_diff,
            'numbers' => NumberResource::collection($this->numbers),
            'events' => UserEventResource::collection($this->events),
            'group_events' => $this->group_events,
            'tickets' => $this->tickets,
            'roles' => $this->roles->pluck('name'),
            'total_to_pay' => $this->totalToPay
        ];
    }

    public function isManager()
    {
        return $this->hasRole('Manager');
    }

    /**
     * Get the numbers assigned to the user.
     */
    public function numbers()
    {
        return $this->hasMany(Number::class)->where('session',config('lanparty.session'));
    }

    /**
     * Get the numbers assigned to the user.
     */
    public function allNumbers()
    {
        return $this->hasMany(Number::class);
    }

    /**
     * formatted_created_at_date attribute.
     *
     * @return mixed
     */
    public function getFormattedCreatedAtDateAttribute()
    {
        return $this->created_at->format('h:i:sA d-m-Y');
    }

    /**
     * Full search attribute.
     *
     * @return mixed
     */
    public function getFullSearchAttribute()
    {
        return "$this->name $this->email $this->givenName $this->sn1 $this->sn2 $this->formatted_created_at_date $this->id";
    }

    /**
     * inscription_paid attribute.
     *
     * @return mixed
     */
    public function getInscriptionPaidAttribute()
    {
        if ($this->tickets) {
            return $this->tickets->pluck('session')->unique()->toArray();
        }
        return [];
    }

    /**
     * inscription_paid attribute.
     *
     * @return mixed
     */
    public function getTotalToPayAttribute()
    {
        return config('lanparty.inscription_price');
//        return config('lanparty.inscription_price') + config('lanparty.event_inscription_price');
    }

    /**
     * Get events the user has been registered
     */
    public function events()
    {
        return $this->morphToMany(Event::class, 'registration')->withTimestamps();
    }

//App\Event::find(Registration::groups($user->groups->pluck('id'))->get()->pluck('event_id'));

    public function getIndividualEventsAttribute() {
        return Event::find(Registration::user($this)->pluck('event_id'));
    }

    public function getAllIndividualEventsAttribute() {
        return Event::withTrashed()->find(Registration::user($this)->pluck('event_id'));
    }

    public function getGroupEventsAttribute() {
        $groupEvents = collect([]);
        optional($this->groups)->each(function ($group) use ($groupEvents) {
            optional($group->events)->each(function ($event) use ($groupEvents) {
                $groupEvents->push($event);
            });
        });
        return $groupEvents->unique('id');
    }

    public function getAllGroupEventsAttribute() {
        return Event::withTrashed()->find(Registration::groups($this->groups->pluck('id'))->get()->pluck('event_id'));
    }

    /**
     * Get all of the events the user has been registered
     */
    public function getAllEventsAttribute()
    {
        return $this->all_individual_events->merge($this->all_group_events);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Pay ticket.
     *
     * @return $this
     */
    public function pay($session)
    {
        $ticket = Ticket::firstAvailableTicket($session);
        if (!$ticket) throw new NotEnoughTicketsException();
        $this->tickets()->save($ticket);
        return $this;
    }

    /**
     * Unpay ticket.
     *
     * @return $this
     */
    public function unpay($session)
    {
        $ticket = $this->tickets()->where(['user_id' => $this->id,'session' => $session])->first();
        $ticket->user_id = null;
        $ticket->save();
        return $this;
    }

    /**
     * Get the ticket associated with the user.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * @return mixed
     */
    public function isSuperAdmin()
    {
        return $this->admin;
    }

    /**
     * The roles that belong to the user.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class,'members');
    }
}
