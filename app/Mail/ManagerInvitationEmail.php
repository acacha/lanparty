<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class ManagerInvitationEmail.
 *
 * @package App\Mail
 */
class ManagerInvitationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;

    /**
     * ManagerInvitationEmail constructor.
     * @param $invitation
     */
    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.manager-invitation')->subject("Invitació per ser gestor de l'aplicació de la LAN Party Institut de l'Ebre");
    }
}
