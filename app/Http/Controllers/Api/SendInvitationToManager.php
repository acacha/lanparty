<?php

namespace App\Http\Controllers\Api;

use App\Facades\InvitationCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Managers\SendInvitationToManagerSend;
use App\Invitation;

/**
 * Class SendInvitationToManager.
 *
 * @package App\Http\Controllers
 */
class SendInvitationToManager extends Controller
{
    /**
     * @return mixed
     */
    public function send(SendInvitationToManagerSend $request)
    {
        Invitation::create([
            'email' => $request->email,
            // Facades
            'code' => InvitationCode::generate() // resolve('mail')->generate()
        ])->send();
    }
}
