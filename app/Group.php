<?php

namespace App;

use App\Exceptions\UserAlreadyMemberOfGroup;
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
     * Get all of the events the groups has been registered
     */
    public function events()
    {
        return $this->morphToMany(Event::class, 'registration');
    }

    /**
     * Find invitation by name.
     *
     * @param $name
     * @return mixed
     */
    public static function findByName($name)
    {
        return self::where('name', $name)->firstOrFail();
    }

    /**
     * Obtain group members.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'members')->orderBy('order','asc');
    }

    /**
     * Leader attribute.
     *
     * @param $value
     * @return mixed
     */
    public function getLeaderAttribute($value)
    {
        return $this->members()->first();
    }

    /**
     * Add user as group member.
     *
     * @param User $user
     */
    public function add(User $user)
    {
        if ($this->hasMember($user)) throw new UserAlreadyMemberOfGroup();
        Member::create([
            'user_id' => $user->id,
            'group_id' => $this->id
        ]);
    }

    /**
     * User leave group.
     *
     * @param User $user
     */
    public function leave(User $user)
    {
        $member = Member::where('group_id',$this->id)->where('user_id',$user->id);
        if ($member) $member->delete();
    }



    /**
     * Check if a user pertains to group.
     *
     * @param User $user
     * @return bool
     */
    public function hasMember(User $user)
    {
        return in_array($user->id, $this->members->pluck('id')->all());
    }

    /**
     * Get member by order.
     *
     * @param $order
     * @return mixed
     */
    public function getMemberByOrder($order)
    {
        return $this->members()->wherePivot('order',$order)->first();
    }

    /**
     * Flags captured by group
     *
     */
    public function flags()
    {
        return $this->belongsToMany('App\Flag')->withPivot('captured')->orderBy('name','asc');
        //return $this->belongsToMany(Flag::class, 'flags')->orderBy('name','asc');
    }
}
