<?php

namespace App;

use App\Mail\ManagerInvitationEmail;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Mail;

/**
 * Class Invitation.
 *
 * @package App
 */
class Invitation extends Model
{
    protected $guarded = [];

    /**
     * Find invitation by code.
     *
     * @param $code
     * @return mixed
     */
    public static function findByCode($code)
    {
        return self::where('code', $code)->firstOrFail();
    }

    /**
     * Use invitation.
     */
    public function use()
    {
        $user = Auth::user();
        $this->user_id = Auth::user()->id;
        $this->save();
        try {
            $user->assignRole('Manager');
        } catch (\Exception $e) {
            //
        }

    }

    /**
     * Check if an invitation has been used.
     *
     * @return bool
     */
    public function hasBeenUsed()
    {
        return $this->user_id !== null;
    }

    /**
     * Send manager invitation email.
     */
    public function send()
    {
        Mail::to($this->email)->send(new ManagerInvitationEmail($this));
    }
}
