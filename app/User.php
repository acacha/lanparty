<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User.
 *
 * @package App
 */
class User extends Authenticatable
{
    use HasApiTokens,Notifiable, HasRoles;

    protected $appends = ['formatted_created_at_date','full_search'];

    public $with = ['numbers'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'givenName', 'sn1', 'sn2'
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

    /**
     * formatted_created_at_date attribute.
     *
     * @return mixed
     */
    public function getFullSearchAttribute()
    {
        return "$this->name $this->email $this->givenName $this->sn1 $this->sn2 $this->formatted_created_at_date $this->id";
    }

    /**
     * Get all of the events the user has been registered
     */
    public function events()
    {
        return $this->morphToMany(Event::class, 'registration');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

}
