<?php

namespace App\Services;

use App\Models\Annonce;
use App\Models\Category;
use App\Models\Vendeur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ImportAnnoncesCSVService
{
    protected AnnonceService $annonceService;

    public function __construct(AnnonceService $annonceService)
    {
        $this->annonceService = $annonceService;
    }

    /**
     * Importe des annonces depuis un fichier CSV
     *
     * @param string $filePath Chemin du fichier CSV
     * @param Vendeur $vendeur Vendeur propriétaire des annonces
     * @param array $options Options d'import (statut, skip_errors, etc.)
     * @return array Rapport d'import
     */
    public function importer(string $filePath, Vendeur $vendeur, array $options = []): array
    {
        $rapport = [
            'total' => 0,
            'reussies' => 0,
            'echecs' => 0,
            'erreurs' => [],
        ];

        $statut = $options['statut'] ?? Annonce::STATUT_BROUILLON;
        $skipErrors = $options['skip_errors'] ?? false;
        $batchSize = $options['batch_size'] ?? 50;

        try {
            $handle = fopen($filePath, 'r');
            
            if (!$handle) {
                throw new \Exception("Impossible d'ouvrir le fichier CSV.");
            }

            // Lire l'en-tête
            $headers = fgetcsv($handle);
            
            if (!$headers) {
                throw new \Exception("Le fichier CSV est vide ou invalide.");
            }

            // Normaliser les en-têtes (minuscules, sans espaces)
            $headers = array_map(function ($header) {
                return strtolower(trim($header));
            }, $headers);

            $ligne = 1; // Compteur de lignes (ligne 1 = en-tête)
            $batch = [];

            while (($row = fgetcsv($handle)) !== false) {
                $ligne++;
                $rapport['total']++;

                try {
                    $data = $this->parserLigne($row, $headers);
                    
                    // Valider les données
                    $validation = $this->validerDonnees($data, $vendeur);
                    
                    if (!$validation['valide']) {
                        $rapport['echecs']++;
                        $rapport['erreurs'][] = [
                            'ligne' => $ligne,
                            'donnees' => $data,
                            'erreurs' => $validation['erreurs'],
                        ];

                        if (!$skipErrors) {
                            continue;
                        }
                    }

                    // Ajouter au batch
                    $batch[] = [
                        'data' => $data,
                        'validation' => $validation,
                    ];

                    // Traiter le batch si plein
                    if (count($batch) >= $batchSize) {
                        $this->traiterBatch($batch, $vendeur, $statut, $rapport);
                        $batch = [];
                    }
                } catch (\Exception $e) {
                    $rapport['echecs']++;
                    $rapport['erreurs'][] = [
                        'ligne' => $ligne,
                        'erreur' => $e->getMessage(),
                    ];

                    if (!$skipErrors) {
                        Log::error("Erreur ligne {$ligne}: " . $e->getMessage());
                    }
                }
            }

            // Traiter le dernier batch
            if (!empty($batch)) {
                $this->traiterBatch($batch, $vendeur, $statut, $rapport);
            }

            fclose($handle);

        } catch (\Exception $e) {
            Log::error('Erreur import CSV: ' . $e->getMessage());
            throw $e;
        }

        return $rapport;
    }

    /**
     * Parse une ligne CSV en tableau associatif
     */
    private function parserLigne(array $row, array $headers): array
    {
        $data = [];

        foreach ($headers as $index => $header) {
            $value = $row[$index] ?? '';
            $data[$header] = trim($value);
        }

        return $data;
    }

    /**
     * Valide les données d'une ligne
     */
    private function validerDonnees(array $data, Vendeur $vendeur): array
    {
        $erreurs = [];

        // Champs obligatoires
        $champsObligatoires = ['type', 'titre', 'description', 'categorie'];
        
        foreach ($champsObligatoires as $champ) {
            if (empty($data[$champ])) {
                $erreurs[] = "Le champ '{$champ}' est obligatoire.";
            }
        }

        // Valider le type
        $typesValides = [Annonce::TYPE_PRODUIT, Annonce::TYPE_SERVICE, Annonce::TYPE_IMMOBILIER, Annonce::TYPE_VEHICULE];
        if (!empty($data['type']) && !in_array(strtolower($data['type']), $typesValides)) {
            $erreurs[] = "Type invalide. Types acceptés: " . implode(', ', $typesValides);
        }

        // Valider la catégorie
        if (!empty($data['categorie'])) {
            $categorie = Category::where('slug', $data['categorie'])
                ->orWhere('nom', $data['categorie'])
                ->first();
            
            if (!$categorie) {
                $erreurs[] = "Catégorie '{$data['categorie']}' introuvable.";
            } else {
                $data['categorie_id'] = $categorie->id;
            }
        }

        // Valider le prix selon le type
        $type = strtolower($data['type'] ?? '');
        
        if (in_array($type, [Annonce::TYPE_PRODUIT, Annonce::TYPE_IMMOBILIER, Annonce::TYPE_VEHICULE])) {
            if (empty($data['prix']) || !is_numeric($data['prix']) || $data['prix'] < 0) {
                $erreurs[] = "Le prix est obligatoire et doit être un nombre positif pour ce type d'annonce.";
            }
        }

        // Validation spécifique par type
        switch ($type) {
            case Annonce::TYPE_VEHICULE:
                if (empty($data['marque'])) {
                    $erreurs[] = "La marque est obligatoire pour un véhicule.";
                }
                if (empty($data['modele'])) {
                    $erreurs[] = "Le modèle est obligatoire pour un véhicule.";
                }
                break;

            case Annonce::TYPE_SERVICE:
                if (empty($data['type_tarification'])) {
                    $erreurs[] = "Le type de tarification est obligatoire pour un service.";
                } elseif (!in_array(strtolower($data['type_tarification']), ['fixe', 'horaire', 'devis'])) {
                    $erreurs[] = "Type de tarification invalide. Valeurs acceptées: fixe, horaire, devis.";
                }
                break;

            case Annonce::TYPE_IMMOBILIER:
                if (empty($data['type_transaction'])) {
                    $erreurs[] = "Le type de transaction est obligatoire pour un bien immobilier.";
                } elseif (!in_array(strtolower($data['type_transaction']), ['vente', 'location'])) {
                    $erreurs[] = "Type de transaction invalide. Valeurs acceptées: vente, location.";
                }
                break;
        }

        return [
            'valide' => empty($erreurs),
            'erreurs' => $erreurs,
            'data' => $data,
        ];
    }

    /**
     * Traite un batch d'annonces
     */
    private function traiterBatch(array $batch, Vendeur $vendeur, string $statut, array &$rapport): void
    {
        DB::beginTransaction();

        try {
            foreach ($batch as $item) {
                if (!$item['validation']['valide']) {
                    continue;
                }

                try {
                    $data = $this->preparerDonnees($item['data'], $statut);
                    $type = strtolower($data['type']);

                    $this->annonceService->creerAnnonce($vendeur, $data, $type);
                    
                    $rapport['reussies']++;
                } catch (\Exception $e) {
                    $rapport['echecs']++;
                    $rapport['erreurs'][] = [
                        'donnees' => $item['data'],
                        'erreur' => $e->getMessage(),
                    ];
                    Log::error('Erreur création annonce: ' . $e->getMessage());
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Prépare les données pour la création d'annonce
     */
    private function preparerDonnees(array $data, string $statut): array
    {
        $type = strtolower($data['type']);

        $prepared = [
            'categorie_id' => $data['categorie_id'],
            'titre' => $data['titre'],
            'description' => $data['description'],
            'statut' => $statut,
        ];

        // Prix
        if (!empty($data['prix'])) {
            $prepared['prix'] = (float) $data['prix'];
        }

        // Type de livraison
        if (!empty($data['type_livraison'])) {
            $prepared['type_livraison'] = strtolower($data['type_livraison']);
        }

        // Disponibilité
        if (!empty($data['disponibilite'])) {
            $prepared['disponibilite'] = strtolower($data['disponibilite']);
        }

        // Données spécifiques selon le type
        switch ($type) {
            case Annonce::TYPE_PRODUIT:
                $prepared['marque'] = $data['marque'] ?? null;
                $prepared['modele'] = $data['modele'] ?? null;
                $prepared['etat'] = $data['etat'] ?? null;
                $prepared['quantite'] = !empty($data['quantite']) ? (int) $data['quantite'] : 1;
                $prepared['prix_moyen_marche'] = !empty($data['prix_moyen_marche']) ? (float) $data['prix_moyen_marche'] : null;
                if (!empty($data['badges'])) {
                    $prepared['badges'] = explode(',', $data['badges']);
                }
                break;

            case Annonce::TYPE_SERVICE:
                $prepared['type_tarification'] = strtolower($data['type_tarification']);
                $prepared['tarif_horaire'] = !empty($data['tarif_horaire']) ? (float) $data['tarif_horaire'] : null;
                $prepared['duree_estimee'] = $data['duree_estimee'] ?? null;
                $prepared['deplacement_inclus'] = !empty($data['deplacement_inclus']) && strtolower($data['deplacement_inclus']) === 'oui';
                $prepared['zone_intervention'] = $data['zone_intervention'] ?? null;
                break;

            case Annonce::TYPE_IMMOBILIER:
                $prepared['type_transaction'] = strtolower($data['type_transaction']);
                $prepared['prix_vente'] = !empty($data['prix_vente']) ? (float) $data['prix_vente'] : null;
                $prepared['loyer_mensuel'] = !empty($data['loyer_mensuel']) ? (float) $data['loyer_mensuel'] : null;
                $prepared['surface'] = !empty($data['surface']) ? (int) $data['surface'] : null;
                $prepared['pieces'] = !empty($data['pieces']) ? (int) $data['pieces'] : null;
                $prepared['chambres'] = !empty($data['chambres']) ? (int) $data['chambres'] : null;
                if (!empty($data['equipements'])) {
                    $prepared['equipements'] = explode(',', $data['equipements']);
                }
                break;

            case Annonce::TYPE_VEHICULE:
                $prepared['marque'] = $data['marque'];
                $prepared['modele'] = $data['modele'];
                $prepared['annee'] = !empty($data['annee']) ? (int) $data['annee'] : null;
                $prepared['kilometrage'] = !empty($data['kilometrage']) ? (int) $data['kilometrage'] : null;
                $prepared['carburant'] = $data['carburant'] ?? null;
                $prepared['boite_vitesse'] = $data['boite_vitesse'] ?? null;
                $prepared['etat'] = $data['etat'] ?? null;
                $prepared['couleur'] = $data['couleur'] ?? null;
                $prepared['portes'] = !empty($data['portes']) ? (int) $data['portes'] : null;
                $prepared['places'] = !empty($data['places']) ? (int) $data['places'] : null;
                break;
        }

        return $prepared;
    }

    /**
     * Génère un template CSV avec les colonnes attendues
     *
     * @param string $type Type d'annonce
     * @return string Contenu du CSV template
     */
    public function genererTemplate(string $type = 'produit'): string
    {
        $colonnes = ['type', 'titre', 'description', 'categorie', 'prix'];

        switch ($type) {
            case Annonce::TYPE_PRODUIT:
                $colonnes = array_merge($colonnes, ['marque', 'modele', 'etat', 'quantite', 'prix_moyen_marche', 'badges', 'type_livraison', 'disponibilite']);
                break;

            case Annonce::TYPE_SERVICE:
                $colonnes = array_merge($colonnes, ['type_tarification', 'tarif_horaire', 'duree_estimee', 'deplacement_inclus', 'zone_intervention']);
                break;

            case Annonce::TYPE_IMMOBILIER:
                $colonnes = array_merge($colonnes, ['type_transaction', 'prix_vente', 'loyer_mensuel', 'surface', 'pieces', 'chambres', 'equipements']);
                break;

            case Annonce::TYPE_VEHICULE:
                $colonnes = array_merge($colonnes, ['marque', 'modele', 'annee', 'kilometrage', 'carburant', 'boite_vitesse', 'etat', 'couleur', 'portes', 'places']);
                break;
        }

        return implode(',', $colonnes) . "\n";
    }
}

