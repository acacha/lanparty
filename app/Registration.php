<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Registration.
 *
 * @package App
 */
class Registration extends Model
{
    protected $guarded = [];

    /**
     * Available scope.
     *
     * @param $query
     * @return mixed
     */
    public function scopeAvailable($query)
    {
        return $query->whereNull('registration_id');
    }

    /**
     * Assigned scope.
     *
     * @param $query
     * @return mixed
     */
    public function scopeAssigned($query)
    {
        return $query->whereNotNull('registration_id');
    }
}
