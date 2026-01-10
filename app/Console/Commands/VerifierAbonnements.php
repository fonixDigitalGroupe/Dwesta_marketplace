<?php

namespace App\Console\Commands;

use App\Services\AbonnementService;
use Illuminate\Console\Command;

class VerifierAbonnements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abonnements:verifier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifie et renouvelle automatiquement les abonnements expirés';

    protected $abonnementService;

    public function __construct(AbonnementService $abonnementService)
    {
        parent::__construct();
        $this->abonnementService = $abonnementService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification des abonnements...');

        // Désactiver les abonnements expirés sans renouvellement automatique
        $desactives = $this->abonnementService->desactiverAbonnementsExpires();
        $this->info("{$desactives} abonnement(s) expiré(s) désactivé(s).");

        // Renouveler les abonnements avec renouvellement automatique
        $renouveles = $this->abonnementService->verifierEtRenouvelerAbonnements();
        $this->info("{$renouveles} abonnement(s) renouvelé(s) automatiquement.");

        $this->info('Vérification terminée.');

        return Command::SUCCESS;
    }
}
