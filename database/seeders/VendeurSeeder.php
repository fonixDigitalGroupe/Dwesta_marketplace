<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendeur;
use App\Models\VendeurParticulier;
use App\Models\VendeurProfessionnel;
use App\Models\PagePro;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class VendeurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clés étrangères pour le nettoyage
        Schema::disableForeignKeyConstraints();
        Vendeur::truncate();
        VendeurParticulier::truncate();
        VendeurProfessionnel::truncate();
        PagePro::truncate();
        Schema::enableForeignKeyConstraints();

        $admin = User::where('email', 'admin@madymarket.com')->first();
        
        // Récupérer les utilisateurs vendeurs
        $vendeurUsers = User::where('email', 'like', 'vendeur%')->orderBy('id')->get();

        if ($vendeurUsers->isEmpty()) {
            $this->command->warn('Aucun utilisateur vendeur trouvé. Exécutez d\'abord UserSeeder.');
            return;
        }

        // Vendeur 1 : Particulier vérifié
        $vendeur1 = Vendeur::create([
            'user_id' => $vendeurUsers[0]->id,
            'type' => 'particulier',
            'statut_verification' => 'verifie',
            'verifie_le' => now()->subDays(30),
            'verifie_par' => $admin?->id,
            'actif' => true,
        ]);

        VendeurParticulier::create([
            'vendeur_id' => $vendeur1->id,
            'type_document' => 'cni',
            'numero_document' => 'CNI123456789',
            'document_path' => 'storage/documents/cni_vendeur1.pdf',
        ]);

        // Vendeur 2 : Professionnel vérifié avec page pro
        $vendeur2 = Vendeur::create([
            'user_id' => $vendeurUsers[1]->id,
            'type' => 'professionnel',
            'statut_verification' => 'verifie',
            'verifie_le' => now()->subDays(45),
            'verifie_par' => $admin?->id,
            'actif' => true,
        ]);

        VendeurProfessionnel::create([
            'vendeur_id' => $vendeur2->id,
            'nom_entreprise' => 'Électronique Plus',
            'numero_registre_commerce' => 'RC-BGI-2023-001',
            'numero_identification_fiscale' => 'NIF-236700001',
            'adresse_entreprise' => 'Avenue de l\'Indépendance, Bangui',
            'description_entreprise' => 'Spécialiste en électronique et high-tech',
            'registre_commerce_path' => 'storage/documents/rc_vendeur2.pdf',
        ]);

        PagePro::create([
            'vendeur_id' => $vendeur2->id,
            'slug' => 'electronique-plus',
            'description' => 'Électronique Plus - Votre spécialiste en électronique et high-tech à Bangui. Produits neufs et garantis.',
            'logo' => 'storage/logos/electronique-plus.png',
            'banniere' => 'storage/banners/electronique-plus-banner.jpg',
            'actif' => true,
        ]);

        // Vendeur 3 : Particulier vérifié
        $vendeur3 = Vendeur::create([
            'user_id' => $vendeurUsers[2]->id,
            'type' => 'particulier',
            'statut_verification' => 'verifie',
            'verifie_le' => now()->subDays(15),
            'verifie_par' => $admin?->id,
            'actif' => true,
        ]);

        VendeurParticulier::create([
            'vendeur_id' => $vendeur3->id,
            'type_document' => 'passeport',
            'numero_document' => 'PASS987654321',
            'document_path' => 'storage/documents/passeport_vendeur3.pdf',
        ]);

        // Vendeur 4 : Professionnel vérifié avec page pro
        $vendeur4 = Vendeur::create([
            'user_id' => $vendeurUsers[3]->id,
            'type' => 'professionnel',
            'statut_verification' => 'verifie',
            'verifie_le' => now()->subDays(60),
            'verifie_par' => $admin?->id,
            'actif' => true,
        ]);

        VendeurProfessionnel::create([
            'vendeur_id' => $vendeur4->id,
            'nom_entreprise' => 'Immo Bangui',
            'numero_registre_commerce' => 'RC-BGI-2022-045',
            'numero_identification_fiscale' => 'NIF-236700002',
            'adresse_entreprise' => 'Quartier Lakouanga, Bangui',
            'description_entreprise' => 'Agence immobilière de référence',
            'registre_commerce_path' => 'storage/documents/rc_vendeur4.pdf',
        ]);

        PagePro::create([
            'vendeur_id' => $vendeur4->id,
            'slug' => 'immo-bangui',
            'description' => 'Immo Bangui - Agence immobilière de référence à Bangui. Location et vente de biens immobiliers.',
            'logo' => 'storage/logos/immo-bangui.png',
            'banniere' => 'storage/banners/immo-bangui-banner.jpg',
            'actif' => true,
        ]);

        // Vendeur 5 : Particulier en attente de vérification
        $vendeur5 = Vendeur::create([
            'user_id' => $vendeurUsers[4]->id,
            'type' => 'particulier',
            'statut_verification' => 'en_attente',
            'verifie_le' => null,
            'verifie_par' => null,
            'actif' => false,
        ]);

        VendeurParticulier::create([
            'vendeur_id' => $vendeur5->id,
            'type_document' => 'cni',
            'numero_document' => 'CNI555666777',
            'document_path' => 'storage/documents/cni_vendeur5.pdf',
        ]);

        $this->command->info('✓ Vendeurs créés : 3 particuliers (2 vérifiés, 1 en attente), 2 professionnels (vérifiés avec pages pro)');
    }
}
