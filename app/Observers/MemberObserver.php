<?php

namespace App\Observers;

use App\Member;
use App\User;

/**
 * Class MemberObserver
 * @package App\Observers
 */
class MemberObserver
{
    /**
     * Listen to the User creating event.
     *
     * @param  \App\Member  $member
     * @return void
     */
    public function creating(Member $member)
    {
        $member->order= $this->getNextOrderValue($member);
    }

    /**
     * @return int
     */
    protected function getNextOrderValue($member)
    {
        return Member::where('group_id',$member->group_id)->max('order') +1;
    }
}