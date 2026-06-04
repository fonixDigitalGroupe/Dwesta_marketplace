<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SmsOtpNotification extends Notification
{
    use Queueable;

    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via(object $notifiable): array
    {
        // On utilise 'mail' pour que ça apparaisse dans Telescope (onglet Mail) pendant le dev
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Vérification SMS (Telescope) - Code: ' . $this->otp)
            ->greeting('Bonjour,')
            ->line('Ceci est une simulation de SMS via Telescope.')
            ->line('Votre code de vérification Karnou est : ' . $this->otp)
            ->line('Veuillez le saisir sur le site pour continuer votre inscription.');
    }
}
