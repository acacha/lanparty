<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the numbers assigned to the user.
     */
    public function numbers()
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
}
