<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * ResetPasswordNotification constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->greeting('Hola!')
                ->line('Heu rebut aquest correu perquè algú ha generat una petició de restauració de la paraula de pas del vostre compte.')
                ->action('Restaurar la paraula de pas', url(config('app.url').route('password.reset', $this->token, false)))
                ->line('Si no heu demanat aquesta petició de restauració de la paraula de pas no cal realitzar cap acció extra (ignoreu aquest correu).')
                ->subject('Notificació de restauració de la paraula de pas')
                ->salutation("Salutacions,
                
Departament d'Informàtica de l'Institut de l'Ebre");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
