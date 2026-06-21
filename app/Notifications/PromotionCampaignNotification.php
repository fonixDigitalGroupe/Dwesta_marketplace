<?php

namespace App\Notifications;

use App\Models\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PromotionCampaignNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $coupon;
    protected $customMessage;
    protected $subject;

    /**
     * Create a new notification instance.
     */
    public function __construct(Coupon $coupon, string $subject, string $customMessage)
    {
        $this->coupon = $coupon;
        $this->subject = $subject;
        $this->customMessage = $customMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $discountLabel = $this->coupon->type === 'percent' 
            ? $this->coupon->value . '%' 
            : number_format($this->coupon->value, 0) . ' FCFA';

        return (new MailMessage)
            ->subject($this->subject)
            ->greeting('Bonjour ' . ($notifiable->name ?? 'Cher Vendeur') . ',')
            ->line('Une nouvelle opportunité de booster vos ventes est disponible sur Karnou !')
            ->line('Nous lançons une campagne promotionnelle avec le code : **' . $this->coupon->code . '**.')
            ->line('Ce code offre une réduction de **' . $discountLabel . '** aux acheteurs.')
            ->line($this->customMessage)
            ->action('Gérer mes produits', route('vendeur.mes-annonces'))
            ->line('En baissant légèrement vos prix pendant cette période, vous maximiserez l\'impact de ce coupon et attirerez plus de clients.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'coupon_code' => $this->coupon->code,
            'discount' => $this->coupon->value,
            'type' => $this->coupon->type,
            'message' => $this->customMessage,
            'subject' => $this->subject,
            'title' => '📦 Nouvelle Campagne Promotionnelle',
        ];
    }
}
