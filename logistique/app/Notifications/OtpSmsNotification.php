<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OtpSmsNotification extends Notification
{
    use Queueable;

    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable): array
    {
        // En local, on utilise log pour que Telescope le capture
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Karnou - Votre code SMS')
            ->line("Votre code de vérification Karnou est : {$this->otp}")
            ->line('Ce code expirera dans 10 minutes.');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'sms_otp',
            'message' => "Votre code de vérification Karnou est : {$this->otp}",
            'otp' => $this->otp,
        ];
    }
}
