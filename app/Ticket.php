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
    public static function addTickets($quantity) {
        foreach (range(1, $quantity ) as $value) {
            Ticket::create();
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
    public static function firstAvailableTicket() {
        return Ticket::available()->orderBy('id', 'asc')->first();
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
