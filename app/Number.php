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
     * @param User $user
     */
    public function assignUser($user)
    {
        $this->user()->associate($user);
        $this->save();
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
}
