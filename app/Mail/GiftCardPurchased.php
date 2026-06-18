<?php

namespace App\Mail;

use App\Models\GiftCard;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GiftCardPurchased extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public GiftCard $giftCard
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎁 Votre Carte Cadeau Karnou est prête !',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.gift_card_purchased',
        );
    }
}
