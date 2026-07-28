<?php

namespace App\Console\Commands;

use App\Services\StripeService;
use Illuminate\Console\Command;

class StripeTestSession extends Command
{
    protected $signature = 'stripe:test-session';

    protected $description = 'Teste la création d\'une session Stripe Checkout depuis le serveur (diagnostic).';

    public function handle(StripeService $stripe): int
    {
        $this->info('Clé secrète chargée : ' . substr((string) config('services.stripe.secret'), 0, 12) . '…');
        $this->info('Tentative de création d\'une session Stripe (5000 FCFA)…');

        try {
            $session = $stripe->createMarketplaceSession(
                5000,
                'https://karnou.fr/checkout/succes',
                'https://karnou.fr/panier',
                'test@karnou.fr',
                ['type' => 'marketplace_order'],
                'Client Test'
            );

            $this->info('✅ SUCCÈS');
            $this->line('Session ID : ' . $session->id);
            $this->line('URL        : ' . $session->url);
        } catch (\Throwable $e) {
            $this->error('❌ ÉCHEC : ' . get_class($e));
            $this->error($e->getMessage());
        }

        return self::SUCCESS;
    }
}
