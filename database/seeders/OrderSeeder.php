<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Annonce;
use App\Models\Vendeur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nettoyage
        Schema::disableForeignKeyConstraints();
        Order::truncate();
        OrderItem::truncate();
        Schema::enableForeignKeyConstraints();

        $acheteurs = User::whereHas('roles', function ($query) {
            $query->where('name', 'acheteur');
        })->get();

        $annonces = Annonce::where('statut', 'publiee')
            ->where('type', 'produit')
            ->get();

        if ($acheteurs->isEmpty() || $annonces->isEmpty()) {
            $this->command->warn('Pas assez de données pour créer des commandes.');
            return;
        }

        // Créer 20 commandes avec différents statuts
        $statuts = [
            Order::STATUT_EN_ATTENTE,
            Order::STATUT_PAYE,
            Order::STATUT_PRET,
            Order::STATUT_EN_ROUTE,
            Order::STATUT_DISPONIBLE,
            Order::STATUT_LIVRE,
            Order::STATUT_ANNULE,
            Order::STATUT_LITIGE,
        ];

        $adresses = [
            'Bangui, PK5, Quartier Résidentiel',
            'Bangui, Boeing, Avenue de la Paix',
            'Bangui, Lakouanga, Rue des Martyrs',
            'Bangui, Centre-Ville, Place de la République',
            'Bangui, Gobongo, Quartier Commercial',
            'Bangui, Fatima, Rue du Marché',
            'Bangui, KM5, Zone Industrielle',
            'Bangui, Combattant, Avenue de l\'Indépendance',
            'Bangui, Miskine, Quartier Populaire',
            'Bangui, Petevo, Rue des Écoles',
        ];

        for ($i = 0; $i < 20; $i++) {
            $acheteur = $acheteurs->random();
            $nbArticles = rand(1, 3);
            $selectedAnnonces = $annonces->random($nbArticles);
            
            $totalProduits = 0;
            foreach ($selectedAnnonces as $annonce) {
                $totalProduits += $annonce->prix * rand(1, 2);
            }

            $fraisPort = rand(2000, 10000);
            $commission = $totalProduits * 0.05; // 5% de commission
            $totalFinal = $totalProduits + $fraisPort;

            // Sélectionner un vendeur parmi les annonces
            $vendeur = $selectedAnnonces->first()->vendeur;

            // Générer tokens pour QR code
            $trackingToken = Str::random(32);
            $qrCodeToken = Str::random(16);

            $order = Order::create([
                'user_id' => $acheteur->id,
                'vendeur_id' => $vendeur->id,
                'reference' => 'MM-' . strtoupper(Str::random(8)),
                'total_produits' => $totalProduits,
                'frais_port' => $fraisPort,
                'commission_plateforme' => $commission,
                'total_final' => $totalFinal,
                'statut' => $statuts[$i % count($statuts)],
                'adresse_livraison' => $adresses[array_rand($adresses)],
                'mode_livraison' => rand(0, 1) ? 'domicile' : 'point_relais',
                'tracking_token' => $trackingToken,
                'qr_code_token' => $qrCodeToken,
                'qr_code_path' => 'storage/qrcodes/' . $qrCodeToken . '.png',
                'notes_vendeur' => $i % 3 == 0 ? 'Livraison urgente demandée' : null,
                'created_at' => now()->subDays(rand(1, 60)),
            ]);

            // Créer les items de commande
            foreach ($selectedAnnonces as $annonce) {
                $quantite = rand(1, 2);
                OrderItem::create([
                    'order_id' => $order->id,
                    'annonce_id' => $annonce->id,
                    'quantite' => $quantite,
                    'prix_unitaire' => $annonce->prix,
                    'prix_total' => $annonce->prix * $quantite,
                ]);
            }
        }

        $this->command->info('✓ Commandes créées : 20 commandes avec différents statuts');
    }
}
