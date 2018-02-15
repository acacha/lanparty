<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Group.
 *
 * @package App
 */
class Group extends Model
{
    protected $guarded = [];

    /**
     * Get all of the events the user has been registered
     */
    public function events()
    {
        return $this->morphToMany(Event::class, 'registration');
    }
}
