<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Vendeur;
use App\Services\ImportAnnoncesCSVService;
use Illuminate\Console\Command;

class ImportAnnoncesCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'annonces:import-csv 
                            {file : Chemin du fichier CSV}
                            {--vendeur= : ID ou email du vendeur}
                            {--statut=brouillon : Statut des annonces (brouillon, publiee)}
                            {--skip-errors : Continuer même en cas d\'erreurs}
                            {--batch-size=50 : Nombre d\'annonces par lot}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importe des annonces depuis un fichier CSV';

    /**
     * Execute the console command.
     */
    public function handle(ImportAnnoncesCSVService $service)
    {
        $filePath = $this->argument('file');
        
        // Vérifier que le fichier existe
        if (!file_exists($filePath)) {
            $this->error("Le fichier '{$filePath}' n'existe pas.");
            return 1;
        }

        // Obtenir le vendeur
        $vendeurIdentifier = $this->option('vendeur');
        
        if (!$vendeurIdentifier) {
            $this->error("Vous devez spécifier un vendeur avec --vendeur=ID ou --vendeur=email");
            return 1;
        }

        $vendeur = $this->obtenirVendeur($vendeurIdentifier);
        
        if (!$vendeur) {
            $this->error("Vendeur introuvable: {$vendeurIdentifier}");
            return 1;
        }

        if (!$vendeur->estVerifie()) {
            $this->error("Le vendeur n'est pas vérifié. Impossible d'importer des annonces.");
            return 1;
        }

        $this->info("Import des annonces pour le vendeur: {$vendeur->user->nom} {$vendeur->user->prenom}");
        $this->info("Fichier: {$filePath}");
        $this->newLine();

        $options = [
            'statut' => $this->option('statut'),
            'skip_errors' => $this->option('skip-errors'),
            'batch_size' => (int) $this->option('batch-size'),
        ];

        try {
            $rapport = $service->importer($filePath, $vendeur, $options);

            // Afficher le rapport
            $this->displayRapport($rapport);

            return 0;
        } catch (\Exception $e) {
            $this->error("Erreur lors de l'import: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Obtient un vendeur par ID ou email
     */
    private function obtenirVendeur(string $identifier): ?Vendeur
    {
        // Essayer par ID
        if (is_numeric($identifier)) {
            $vendeur = Vendeur::find($identifier);
            if ($vendeur) {
                return $vendeur;
            }
        }

        // Essayer par email
        $user = User::where('email', $identifier)->first();
        if ($user && $user->estVendeur()) {
            return $user->vendeur;
        }

        return null;
    }

    /**
     * Affiche le rapport d'import
     */
    private function displayRapport(array $rapport): void
    {
        $this->newLine();
        $this->info("=== RAPPORT D'IMPORT ===");
        $this->newLine();
        
        $this->line("Total de lignes traitées: {$rapport['total']}");
        $this->line("Annonces créées avec succès: <fg=green>{$rapport['reussies']}</>");
        $this->line("Échecs: <fg=red>{$rapport['echecs']}</>");
        
        if (!empty($rapport['erreurs'])) {
            $this->newLine();
            $this->warn("Erreurs rencontrées:");
            
            $afficherErreurs = $this->confirm('Voulez-vous afficher les détails des erreurs?', false);
            
            if ($afficherErreurs) {
                foreach ($rapport['erreurs'] as $index => $erreur) {
                    $this->newLine();
                    $this->error("Erreur #" . ($index + 1));
                    
                    if (isset($erreur['ligne'])) {
                        $this->line("Ligne: {$erreur['ligne']}");
                    }
                    
                    if (isset($erreur['erreurs']) && is_array($erreur['erreurs'])) {
                        foreach ($erreur['erreurs'] as $msg) {
                            $this->line("  - {$msg}");
                        }
                    } elseif (isset($erreur['erreur'])) {
                        $this->line("  - {$erreur['erreur']}");
                    }
                    
                    if (isset($erreur['donnees'])) {
                        $this->line("Données: " . json_encode($erreur['donnees'], JSON_UNESCAPED_UNICODE));
                    }
                }
            }
        }
        
        $this->newLine();
        $this->info("Import terminé!");
    }
}
