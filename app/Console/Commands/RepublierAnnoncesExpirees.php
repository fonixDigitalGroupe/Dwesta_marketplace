<?php

namespace App\Console\Commands;

use App\Models\Annonce;
use App\Services\AnnonceOptionService;
use Illuminate\Console\Command;

class RepublierAnnoncesExpirees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'annonces:republier-expirees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Républie automatiquement les annonces expirées avec l\'option de republication automatique';

    /**
     * Execute the console command.
     */
    public function handle(AnnonceOptionService $service)
    {
        $this->info('Vérification des annonces à republier...');

        // Récupérer les annonces expirées avec republication automatique
        $annonces = Annonce::where('statut', Annonce::STATUT_EXPIREE)
            ->whereHas('options', function ($q) {
                $q->where('republication_auto', true);
            })
            ->get();

        $republiees = 0;

        foreach ($annonces as $annonce) {
            if ($service->republierAnnonce($annonce)) {
                $republiees++;
                $this->info("Annonce #{$annonce->id} republiée avec succès.");
            }
        }

        $this->info("Republication terminée. {$republiees} annonce(s) republiée(s).");
    }
}
