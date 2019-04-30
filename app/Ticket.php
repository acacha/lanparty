<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ticket.
 *
 * @package App
 */
class Ticket extends Model
{
    protected $guarded = [];

    /**
     * Add numbers.
     *
     * @param $quantity
     */
    public static function addTickets($quantity, $session) {
        foreach (range(1, $quantity ) as $value) {
            Ticket::create([
                'session' => $session
            ]);
        }
    }

    /**
     * Tickets.
     *
     */
    public static function tickets() {
        return map_collection(Ticket::with('user')->get());
    }

    /**
     * Get the user that owns the ticket.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get first available number.
     *
     * @return mixed
     */
    public static function firstAvailableTicket($session) {
        return Ticket::available()->where('session',$session)->orderBy('id', 'asc')->first();
    }

    /**
     * Available scope.
     *
     * @param $query
     * @return mixed
     */
    public function scopeAvailable($query)
    {
        return $query->where('user_id', null);
    }

    /**
     * Assign user.
     *
     * @param $user
     * @param string $description
     * @return $this
     */
    public function assignUser($user)
    {
        $this->user()->associate($user);
        $this->save();
        return $this;
    }

    public function map()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'session' => $this->session,
            'user_name' => optional($this->user)->name,
            'user_email' => optional($this->user)->email,
            'user_sn1' => optional($this->user)->sn1,
            'user_sn2' => optional($this->user)->sn2,
            'user_givenName' => optional($this->user)->givenName,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
