<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LivreurTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Créer le Livreur
        $userLivreur = \App\Models\User::firstOrCreate(
            ['email' => 'livreur@karnou.com'],
            [
                'nom' => 'Test',
                'prenom' => 'Livreur',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_active' => true,
            ]
        );

        $livreur = \App\Models\Livreur::firstOrCreate(
            ['user_id' => $userLivreur->id],
            [
                'matricule' => 'LIV-'.rand(1000,9999),
                'type_vehicule' => 'moto',
                'type_document' => 'cni',
                'numero_document' => '123456789',
                'statut_verification' => 'approuve',
                'actif' => true,
                'latitude' => 5.345317,
                'longitude' => -4.024429,
            ]
        );

        // 2. Créer l'Acheteur
        $userAcheteur = \App\Models\User::firstOrCreate(
            ['email' => 'acheteur@karnou.com'],
            [
                'nom' => 'Client',
                'prenom' => 'Test',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_active' => true,
            ]
        );

        // 3. Créer le Vendeur
        $userVendeur = \App\Models\User::firstOrCreate(
            ['email' => 'vendeur@karnou.com'],
            [
                'nom' => 'Boutique',
                'prenom' => 'Test',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_active' => true,
            ]
        );
        $vendeur = \App\Models\Vendeur::firstOrCreate(
            ['user_id' => $userVendeur->id],
            [
                'type' => 'professionnel',
                'statut_verification' => 'verifie',
                'actif' => true
            ]
        );

        \App\Models\PagePro::firstOrCreate(
            ['vendeur_id' => $vendeur->id],
            [
                'nom_boutique' => 'Ma Super Boutique',
                'slug' => 'ma-super-boutique',
                'description' => 'Test boutique',
            ]
        );

        // 4. Créer une Mission de Test (Commande Prête)
        $order = \App\Models\Order::create([
            'user_id' => $userAcheteur->id,
            'vendeur_id' => $vendeur->id,
            'reference' => 'CMD-TEST-'.rand(1000,9999),
            'total_produits' => 15000,
            'frais_port' => 1000,
            'commission_plateforme' => 500,
            'total_final' => 16000,
            'statut' => \App\Models\Order::STATUT_PRET,
            'adresse_livraison' => 'Cocody, Abidjan, Côte d\'Ivoire',
        ]);
    }
}
