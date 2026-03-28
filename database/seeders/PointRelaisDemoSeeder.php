<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PointRelais;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class PointRelaisDemoSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Point Relais Manager User
        $email = 'manager@relais.com';
        $manager = User::where('email', $email)->first();

        if (!$manager) {
            $manager = User::create([
                'prenom' => 'Jean',
                'nom' => 'Relais',
                'email' => $email,
                'password' => bcrypt('password'),
                'telephone' => '770000000',
                'email_verified_at' => now(),
            ]);
            
            // Assign role
            if (!Role::where('name', 'point_relais')->exists()) {
                Role::create(['name' => 'point_relais']);
            }
            $manager->assignRole('point_relais');
        }

        // 2. Create Point Relais
        $point = PointRelais::firstOrCreate(
            ['nom' => 'Relais Express Dakar'],
            [
                'adresse' => 'Avenue Bourguiba, Dakar, Sénégal',
                'telephone' => '338000000',
                'pays' => 'Sénégal',
                'is_active' => true,
                'horaires' => "Lundi - Vendredi : 08h00 - 20h00\nSamedi : 09h00 - 18h00",
            ]
        );

        // Attach manager
        if (!$point->users()->where('user_id', $manager->id)->exists()) {
            $point->users()->attach($manager->id);
        }

        // 3. Create Dummy Data for Orders
        $buyer = User::inRandomOrder()->first() ?? $manager;
        $seller = Vendeur::first();
        
        if (!$seller) {
            // Create a dummy seller if none exists
            $sellerUser = User::create([
                'prenom' => 'Vendeur',
                'nom' => 'Test',
                'email' => 'vendeur@test.com',
                'password' => bcrypt('password'),
            ]);
            $seller = Vendeur::create([
                'user_id' => $sellerUser->id,
                'nom_boutique' => 'Boutique Test',
                'adresse' => 'Dakar',
            ]);
        }

        $annonce = Annonce::first();
        if (!$annonce) {
            $annonce = Annonce::create([
                'vendeur_id' => $seller->id,
                'titre' => 'Smartphone Test',
                'description' => 'Un super téléphone',
                'prix' => 150000,
                'etat' => 'neuf',
                'disponibilite' => 'en_stock',
            ]);
        }

        // Create Incoming Orders (En Route)
        for ($i = 0; $i < 3; $i++) {
            $order = Order::create([
                'user_id' => $buyer->id,
                'vendeur_id' => $seller->id,
                'destination_point_relais_id' => $point->id,
                'reference' => 'CMD-' . strtoupper(Str::random(8)),
                'total_produits' => 150000,
                'total_final' => 152000,
                'statut' => Order::STATUT_EN_ROUTE,
                'commission_plateforme' => 0,
                'commission_point_relais' => 500,
                'created_at' => now()->subDays(rand(1, 5)),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'annonce_id' => $annonce->id,
                'quantite' => 1,
                'prix_unitaire' => 150000,
            ]);
        }

        // Create Ready Orders (Disponible)
        for ($i = 0; $i < 4; $i++) {
            $order = Order::create([
                'user_id' => $buyer->id,
                'vendeur_id' => $seller->id,
                'destination_point_relais_id' => $point->id,
                'reference' => 'CMD-' . strtoupper(Str::random(8)),
                'total_produits' => 150000,
                'total_final' => 152000,
                'statut' => Order::STATUT_DISPONIBLE,
                'commission_plateforme' => 0,
                'commission_point_relais' => 500,
                'created_at' => now()->subDays(rand(2, 10)),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'annonce_id' => $annonce->id,
                'quantite' => 1,
                'prix_unitaire' => 150000,
            ]);
        }

        // Create Delivered Orders (History)
        for ($i = 0; $i < 5; $i++) {
            $order = Order::create([
                'user_id' => $buyer->id,
                'vendeur_id' => $seller->id,
                'destination_point_relais_id' => $point->id,
                'reference' => 'CMD-' . strtoupper(Str::random(8)),
                'total_produits' => 150000,
                'total_final' => 152000,
                'statut' => Order::STATUT_LIVRE,
                'commission_plateforme' => 0,
                'commission_point_relais' => 500,
                'created_at' => now()->subDays(rand(10, 30)),
                'updated_at' => now()->subDays(rand(1, 10)),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'annonce_id' => $annonce->id,
                'quantite' => 1,
                'prix_unitaire' => 150000,
            ]);
        }
        
        $this->command->info("Point Relais Demo Data Seeded! Login as manager@relais.com / password");
    }
}
