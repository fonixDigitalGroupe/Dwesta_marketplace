<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendeur;
use App\Models\VendeurParticulier;
use App\Models\VendeurProfessionnel;
use App\Models\VendeurAbonnement;
use App\Models\Abonnement;
use App\Models\PagePro;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserDemoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::role('admin')->first();

        // 1. 5 Utilisateurs Simples (Acheteurs)
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'civilite' => $i % 2 == 0 ? 'Mme' : 'M.',
                'prenom' => "Acheteur$i",
                'nom' => "Demo",
                'email' => "acheteur$i.demo@example.com",
                'password' => Hash::make('password'),
                'telephone' => "+2367010000$i",
                'email_verified_at' => now(),
                'telephone_verified_at' => now(),
                'is_active' => true,
            ]);
            $user->assignRole('acheteur');
        }

        // 2. 5 Vendeurs Particuliers
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'civilite' => $i % 2 == 0 ? 'Mme' : 'M.',
                'prenom' => "VendeurPart$i",
                'nom' => "Demo",
                'email' => "vendeur.part$i.demo@example.com",
                'password' => Hash::make('password'),
                'telephone' => "+2367020000$i",
                'email_verified_at' => now(),
                'telephone_verified_at' => now(),
                'is_active' => true,
            ]);
            $user->assignRole('vendeur');
            $user->assignRole('Vendeur Particulier');

            $vendeur = Vendeur::create([
                'user_id' => $user->id,
                'type' => 'particulier',
                'statut_verification' => 'verifie',
                'verifie_le' => now(),
                'verifie_par' => $admin?->id,
                'actif' => true,
            ]);

            VendeurParticulier::create([
                'vendeur_id' => $vendeur->id,
                'type_document' => 'cni',
                'numero_document' => "CNI-PART-$i-" . Str::random(5),
            ]);
        }

        // 3. 5 Vendeurs Professionnels — avec documents complets + abonnement Expert actif
        $companies = [
            'Boutique Alpha', 'Dépôt Express', 'Fashion Store', 'Tech Hub', 'Global Market'
        ];

        // Récupérer le plan Expert (créé par AbonnementSeeder)
        $abonnementExpert = Abonnement::where('type', 'expert')->first();

        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'civilite' => $i % 2 == 0 ? 'Mme' : 'M.',
                'prenom' => "VendeurPro$i",
                'nom' => "Demo",
                'email' => "vendeur.pro$i.demo@example.com",
                'password' => Hash::make('password'),
                'telephone' => "+2367030000$i",
                'email_verified_at' => now(),
                'telephone_verified_at' => now(),
                'is_active' => true,
            ]);
            $user->assignRole('vendeur');
            $user->assignRole('Vendeur Professionnel');

            $vendeur = Vendeur::create([
                'user_id' => $user->id,
                'type' => 'professionnel',
                'statut_verification' => 'verifie',
                'verifie_le' => now(),
                'verifie_par' => $admin?->id,
                'actif' => true,
            ]);

            $companyName = $companies[$i - 1];
            $companySlug = Str::slug($companyName);

            // Informations complètes du vendeur professionnel avec documents obligatoires
            VendeurProfessionnel::create([
                'vendeur_id'                    => $vendeur->id,
                'nom_entreprise'                => $companyName,
                'numero_registre_commerce'      => "RC-CAF-BUI-2024-B-{$i}" . strtoupper(Str::random(4)),
                'registre_commerce_path'        => "documents/demo/registre_commerce_{$companySlug}.pdf",
                'date_expiration_registre'      => now()->addYears(3),
                'numero_identification_fiscale' => "NIF-CAF-{$i}" . strtoupper(Str::random(6)),
                'adresse_entreprise'            => "Bangui, Avenue {$i}, Quartier Commercial",
                'telephone_entreprise'          => "+2367050000{$i}",
                'email_entreprise'              => "contact@{$companySlug}.com",
                'description_entreprise'        => "{$companyName} est une entreprise reconnue pour la qualité de ses produits et services depuis 2020.",
                'site_web'                      => "https://www.{$companySlug}.com",
            ]);

            // Abonnement Expert actif (1 an)
            if ($abonnementExpert) {
                VendeurAbonnement::create([
                    'vendeur_id'                 => $vendeur->id,
                    'abonnement_id'              => $abonnementExpert->id,
                    'date_debut'                 => now(),
                    'date_fin'                   => now()->addYear(),
                    'actif'                      => true,
                    'renouvellement_automatique' => true,
                    'nombre_annonces_utilisees'  => 0,
                ]);
            }

            // Page Pro
            PagePro::create([
                'vendeur_id'  => $vendeur->id,
                'slug'        => $companySlug,
                'description' => "Bienvenue chez {$companyName}. Nous proposons les meilleurs produits et services.",
                'actif'       => true,
            ]);
        }

        $this->command->info('✓ Seeder Demo terminé : 5 acheteurs, 5 vendeurs particuliers, 5 vendeurs professionnels (docs complets + abonnement Expert) créés.');
    }
}
