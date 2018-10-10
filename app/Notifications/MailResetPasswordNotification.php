<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MailResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
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
            ->from('indreze@notre-dame-reze.fr')
            ->subject( 'Réinitialisation de votre mot de passe' )
            ->line( "Vous avez demandé à changer de mot de passe. " )
            ->line( "Pour cela, veuillez cliquer sur le lien ci-dessous : " )
            ->action('Changez de mot de passe', url(config('app.url') . route('password.reset', $this->token, false)))
            ->line("Si vous n'êtes pas à l'origine de cette action, vous pouvez ignorer ce message et contacter l'administrateur du site.");
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
