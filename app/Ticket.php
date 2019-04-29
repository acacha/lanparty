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
}
