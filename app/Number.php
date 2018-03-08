<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Number.
 * 
 * @package App
 */
class Number extends Model
{
    protected $guarded = [];

    /**
     * Add numbers.
     *
     * @param $quantity
     */
    public static function addNumbers($quantity) {
        $initial = Number::last() ? Number::last() + 1 : 1;
        foreach (range($initial, $initial + $quantity -1 ) as $value) {
            Number::create([
                'value' => $value
            ]);
        }
    }

    /**
     * Get first available number.
     *
     * @return mixed
     */
    public static function firstAvailableNumber() {
        return Number::available()->orderBy('value', 'asc')->first();
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
     * Assigned scope.
     *
     * @param $query
     * @return mixed
     */
    public function scopeAssigned($query)
    {
        return $query->whereNotNull('user_id');
    }


    /**
     * Obtain last number
     *
     * @return mixed
     */
    public static function last() {
        $lastNumber = Number::orderBy('value', 'desc')->first();
        return $lastNumber ? (int) $lastNumber->value : null;
    }

    /**
     * Assign user.
     *
     * @param $user
     * @param string $description
     * @return $this
     */
    public function assignUser($user, $description = '')
    {
        $this->user()->associate($user);
        $this->description = $description;
        $this->save();
        return $this;
    }

    /**
     * Get the user record associated with the number.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * full_search attribute.
     *
     * @return mixed
     */
    public function getFullSearchAttribute()
    {
        if ($this->user_id) {
            return $this->value . ' ' . $this->description . ' ' . $this->user->givenName . ' ' . $this->user->sn1 . ' ' .
                $this->user->sn2 . ' ' . $this->user->name;
        }
        return "$this->value $this->description";
    }
}
