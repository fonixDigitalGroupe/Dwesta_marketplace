<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Transporteur;
use App\Models\Livreur;
use App\Models\Order;
use App\Models\PointRelais;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::where('email', '!=', '')->delete(); // Tout supprimer
        Transporteur::query()->delete();
        Livreur::query()->delete();
        PointRelais::query()->delete();

        // 1. Assurer l'existence des rôles
        $roles = ['admin', 'transporteur', 'livreur', 'point relais', 'vendeur', 'client'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 2. Créer l'administrateur
        $admin = User::firstOrCreate([
            'email' => 'admn@karnou.com'
        ], [
            'prenom' => 'Landing',
            'nom' => 'Diallo',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // 3. Créer 5 Transporteurs
        $transporteurData = [
            ['prenom' => 'Modou', 'nom' => 'Fall', 'email' => 'modou.transport@gmail.com', 'marque' => 'Toyota', 'modele' => 'Hilux', 'immat' => 'DK-1234-A'],
            ['prenom' => 'Ibrahima', 'nom' => 'Sow', 'email' => 'ibra.logistique@hotmail.com', 'marque' => 'Mercedes', 'modele' => 'Sprinter', 'immat' => 'TH-5678-B'],
            ['prenom' => 'Fatou', 'nom' => 'Ndiaye', 'email' => 'fatou.trans@yahoo.fr', 'marque' => 'Renault', 'modele' => 'Master', 'immat' => 'SL-9012-C'],
            ['prenom' => 'Abdou', 'nom' => 'Gueye', 'email' => 'abdou.car@gmail.com', 'marque' => 'Peugeot', 'modele' => 'Expert', 'immat' => 'DK-3456-D'],
            ['prenom' => 'Moussa', 'nom' => 'Diop', 'email' => 'moussa.fret@gmail.com', 'marque' => 'Ford', 'modele' => 'Transit', 'immat' => 'KL-7890-E'],
        ];

        foreach ($transporteurData as $data) {
            $user = User::create([
                'prenom' => $data['prenom'],
                'nom' => $data['nom'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'telephone' => '77' . rand(1000000, 9999999),
            ]);
            $user->assignRole('transporteur');

            Transporteur::create([
                'user_id' => $user->id,
                'type_vehicule' => 'Camion',
                'marque_vehicule' => $data['marque'],
                'modele_vehicule' => $data['modele'],
                'immatriculation' => $data['immat'],
                'numero_permis' => 'SN-PERM-' . Str::upper(Str::random(8)),
                'statut_verification' => 'verifie',
                'actif' => true,
            ]);
        }

        // 4. Créer 5 Livreurs
        $livreurData = [
            ['prenom' => 'Bakary', 'nom' => 'Sane', 'email' => 'bakary.livreur@gmail.com', 'vehicule' => 'Moto'],
            ['prenom' => 'Ousmane', 'nom' => 'Kane', 'email' => 'ousmane.moto@gmail.com', 'vehicule' => 'Moto'],
            ['prenom' => 'Yacine', 'nom' => 'Ba', 'email' => 'yacine.voiture@gmail.com', 'vehicule' => 'Voiture'],
            ['prenom' => 'Mamadou', 'nom' => 'Cisse', 'email' => 'mamadou.express@gmail.com', 'vehicule' => 'Moto'],
            ['prenom' => 'Khady', 'nom' => 'Faye', 'email' => 'khady.livraison@gmail.com', 'vehicule' => 'Voiture'],
        ];

        foreach ($livreurData as $data) {
            $user = User::create([
                'prenom' => $data['prenom'],
                'nom' => $data['nom'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'telephone' => '78' . rand(1000000, 9999999),
            ]);
            $user->assignRole('livreur');

            Livreur::create([
                'user_id' => $user->id,
                'type_vehicule' => $data['vehicule'],
                'type_document' => 'CNI',
                'numero_document' => 'SN-CNI-' . rand(1000000, 9999999),
                'statut_verification' => 'verifie',
                'actif' => true,
            ]);
        }

        // 5. Créer 5 Point Relais
        $pointRelaisData = [
            ['nom' => 'Espace Dakar Plateau', 'ville' => 'Dakar'],
            ['nom' => 'Multiservices Almadies', 'ville' => 'Dakar'],
            ['nom' => 'Relais Express Thiès', 'ville' => 'Thiès'],
            ['nom' => 'Point Colis Saint-Louis', 'ville' => 'Saint-Louis'],
            ['nom' => 'Kiosque Mbour Centre', 'ville' => 'Mbour'],
        ];

        foreach ($pointRelaisData as $index => $data) {
            $user = User::create([
                'prenom' => 'Gestionnaire',
                'nom' => 'PR ' . ($index + 1),
                'email' => 'relais' . ($index + 1) . '@karnou.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
            $user->assignRole('point relais');

            $pr = PointRelais::create([
                'nom' => $data['nom'],
                'adresse' => 'Quartier Central, ' . $data['ville'],
                'pays' => 'Sénégal',
                'region' => $data['ville'],
                'telephone' => '33' . rand(1000000, 9999999),
                'horaires' => 'Lun-Sam: 08h-20h',
                'is_active' => true,
            ]);

            // Associer l'utilisateur au point relais
            $pr->users()->attach($user->id);
        }

        // 6. Créer quelques commandes de test pour la logistique
        $vendeurUser = User::create([
            'prenom' => 'Vendeur',
            'nom' => 'Test',
            'email' => 'vendeur@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $vendeurUser->assignRole('vendeur');

        // Créer le profil vendeur
        $vendeurProfile = \App\Models\Vendeur::create([
            'user_id' => $vendeurUser->id,
            'type' => 'professionnel',
            'statut_verification' => 'verifie',
            'actif' => true,
        ]);

        for ($i = 1; $i <= 3; $i++) {
            Order::create([
                'user_id' => $admin->id,
                'vendeur_id' => $vendeurProfile->id,
                'reference' => 'ORD-' . strtoupper(Str::random(8)),
                'total_produits' => 5000 * $i,
                'frais_port' => 2000,
                'commission_plateforme' => 500, // Ajout pour éviter null
                'total_final' => (5000 * $i) + 2000,
                'statut' => Order::STATUT_PRET,
                'commission_transporteur' => 1500,
                'commission_livreur' => 500,
                'pays_depart' => 'Sénégal',
                'pays_destination' => 'France',
                'adresse_livraison' => '123 Rue de Paris, Paris',
                'mode_livraison' => 'standard', // Valeur par défaut
            ]);
        }
    }
}
