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
    public function scopeAvailable($query)
    {
        return $query->whereNull('registration_id');
    }

    public function scopeAssigned($query)
    {
        return $query->whereNotNull('registration_id');
    }
}
