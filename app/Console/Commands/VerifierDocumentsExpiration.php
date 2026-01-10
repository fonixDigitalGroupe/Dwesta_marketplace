<?php

namespace App\Console\Commands;

use App\Models\Vendeur;
use App\Models\VendeurParticulier;
use App\Models\VendeurProfessionnel;
use App\Notifications\DocumentExpirationNotification;
use App\Services\DocumentNotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VerifierDocumentsExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'documents:verifier-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifie les documents qui expirent bientôt et envoie des notifications';

    protected $notificationService;

    public function __construct(DocumentNotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification des documents expirés...');

        $notificationsEnvoyees = 0;

        // Vérifier les documents des particuliers
        $particuliers = VendeurParticulier::whereNotNull('date_expiration_document')
            ->where('date_expiration_document', '>=', now())
            ->where('date_expiration_document', '<=', now()->addDays(30))
            ->with('vendeur.user')
            ->get();

        foreach ($particuliers as $particulier) {
            if ($this->notificationService->doitEnvoyerNotification($particulier->vendeur, 'particulier', $particulier->date_expiration_document)) {
                $this->envoyerNotification($particulier->vendeur, 'particulier', $particulier->date_expiration_document);
                $notificationsEnvoyees++;
            }
        }

        // Vérifier les registres de commerce des professionnels
        $professionnels = VendeurProfessionnel::whereNotNull('date_expiration_registre')
            ->where('date_expiration_registre', '>=', now())
            ->where('date_expiration_registre', '<=', now()->addDays(30))
            ->with('vendeur.user')
            ->get();

        foreach ($professionnels as $professionnel) {
            if ($this->notificationService->doitEnvoyerNotification($professionnel->vendeur, 'professionnel', $professionnel->date_expiration_registre)) {
                $this->envoyerNotification($professionnel->vendeur, 'professionnel', $professionnel->date_expiration_registre);
                $notificationsEnvoyees++;
            }
        }

        // Vérifier les abonnements expirés
        $vendeursAvecAbonnements = Vendeur::whereHas('abonnementActif', function ($query) {
            $query->where('date_fin', '>=', now())
                  ->where('date_fin', '<=', now()->addDays(30));
        })->with(['abonnementActif.abonnement', 'user'])->get();

        foreach ($vendeursAvecAbonnements as $vendeur) {
            $dateFin = $vendeur->abonnementActif->date_fin;
            if ($this->notificationService->doitEnvoyerNotification($vendeur, 'abonnement', $dateFin)) {
                $this->envoyerNotification($vendeur, 'abonnement', $dateFin);
                $notificationsEnvoyees++;
            }
        }

        $this->info("{$notificationsEnvoyees} notification(s) envoyée(s).");
        $this->info('Vérification terminée.');

        return Command::SUCCESS;
    }

    /**
     * Envoyer une notification au vendeur
     */
    protected function envoyerNotification(Vendeur $vendeur, string $type, $dateExpiration): void
    {
        $joursRestants = now()->diffInDays($dateExpiration);
        
        try {
            $vendeur->user->notify(new DocumentExpirationNotification($type, $dateExpiration, $joursRestants));
            
            // Enregistrer la notification
            $this->notificationService->enregistrerNotification($vendeur, $type, $dateExpiration, $joursRestants);
        } catch (\Exception $e) {
            $this->error("Erreur lors de l'envoi de la notification pour le vendeur {$vendeur->id}: " . $e->getMessage());
        }
    }
}
