<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Prize.
 *
 * @package App
 */
class Prize extends Model
{
    protected $guarded = [];

    /**
     * Get the partner that owns the prize.
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Get the user that owns the prize.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the number that owns the prize.
     */
    public function number()
    {
        return $this->belongsTo(Number::class);
    }

    /**
     * Scope a query to only include available prizes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('user_id', null)->where('number_id', null);
    }

    /**
     * Winners scope.
     *
     * @param $query
     * @return mixed
     */
    public function scopeWinners($query)
    {
        return $query->where('number_id','!=', null);
    }

}
