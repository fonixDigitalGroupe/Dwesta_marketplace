<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCredentialsNotification extends Notification
{
    use Queueable;

    protected $password;
    protected $prenom;
    protected $email;

    /**
     * Create a new notification instance.
     */
    public function __construct($prenom, $email, $password)
    {
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Vos informations de connexion - Dwesta Marketplace')
                    ->greeting('Bonjour ' . $this->prenom . ',')
                    ->line('Votre compte administrateur a été créé avec succès sur Dwesta Marketplace.')
                    ->line('Voici vos informations de connexion :')
                    ->line('**Email :** ' . $this->email)
                    ->line('**Mot de passe :** ' . $this->password)
                    ->action('Se connecter', url('/login'))
                    ->line('Pour des raisons de sécurité, nous vous recommandons de changer votre mot de passe dès votre première connexion.')
                    ->line('Merci d\'utiliser notre plateforme !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
