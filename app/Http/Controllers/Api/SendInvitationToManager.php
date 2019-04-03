<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;

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
        dd('dsasd');
    }
}
