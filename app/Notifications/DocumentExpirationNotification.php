<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentExpirationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $type;
    protected $dateExpiration;
    protected int $joursRestants;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $type, $dateExpiration, int $joursRestants)
    {
        $this->type = $type;
        $this->dateExpiration = $dateExpiration;
        $this->joursRestants = $joursRestants;
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
        $typeDocument = match($this->type) {
            'particulier' => 'votre document d\'identité',
            'professionnel' => 'votre registre de commerce',
            'abonnement' => 'votre abonnement',
            default => 'votre document'
        };

        $message = (new MailMessage)
            ->subject('Alerte : Document expirant bientôt - Mady Market')
            ->greeting('Bonjour ' . $notifiable->prenom . ',')
            ->line("Nous vous informons que {$typeDocument} expire dans {$this->joursRestants} jour(s).")
            ->line("Date d'expiration : " . $this->dateExpiration->format('d/m/Y'));

        if ($this->type === 'abonnement') {
            $message->action('Renouveler mon abonnement', route('abonnements.mon-abonnement'));
        } else {
            $message->action('Mettre à jour mes documents', route('vendeur.show'));
        }

        $message->line('Merci de mettre à jour vos informations pour continuer à utiliser notre plateforme.');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->type,
            'date_expiration' => $this->dateExpiration->format('Y-m-d'),
            'jours_restants' => $this->joursRestants,
        ];
    }
}
