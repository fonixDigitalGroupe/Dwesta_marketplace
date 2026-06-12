<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Channels\OrangeSmsChannel;

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
        return [OrangeSmsChannel::class];
    }

    public function toOrangeSms($notifiable)
    {
        return "Votre code de vérification Karnou est : " . $this->otp . ". Ce code expire dans 15 minutes.";
    }
}
