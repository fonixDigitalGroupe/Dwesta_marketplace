<?php

namespace Database\Seeders;

use App\Models\CreditTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreditTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nettoyage
        Schema::disableForeignKeyConstraints();
        CreditTransaction::truncate();
        Schema::enableForeignKeyConstraints();

        $vendeurs = User::role('vendeur')->get();

        if ($vendeurs->isEmpty()) {
            $this->command->warn('Aucun vendeur trouvé.');
            return;
        }

        // Packs de crédits disponibles
        $packs = [
            ['montant' => 10000, 'credits' => 10000],
            ['montant' => 25000, 'credits' => 27000],
            ['montant' => 50000, 'credits' => 56000],
            ['montant' => 100000, 'credits' => 115000],
        ];

        // Options payantes
        $options = [
            ['type' => 'a_la_une', 'cout' => 5000],
            ['type' => 'urgent', 'cout' => 3000],
            ['type' => 'video', 'cout' => 8000],
        ];

        foreach ($vendeurs as $vendeur) {
            // Chaque vendeur achète 2-4 packs de crédits
            $nbAchats = rand(2, 4);
            for ($i = 0; $i < $nbAchats; $i++) {
                $pack = $packs[array_rand($packs)];
                
                CreditTransaction::create([
                    'user_id' => $vendeur->id,
                    'type' => 'credit',
                    'amount' => $pack['credits'],
                    'description' => 'Achat pack ' . number_format($pack['credits'], 0, ',', ' ') . ' crédits',
                    'reference' => 'CREDIT-' . strtoupper(Str::random(10)),
                    'created_at' => now()->subDays(rand(1, 60)),
                ]);
            }

            // Chaque vendeur consomme des crédits pour des options
            $nbConsommations = rand(3, 8);
            for ($i = 0; $i < $nbConsommations; $i++) {
                $option = $options[array_rand($options)];
                
                CreditTransaction::create([
                    'user_id' => $vendeur->id,
                    'type' => 'debit',
                    'amount' => $option['cout'], // Amount positive or negative? Migration doesn't specify but usually debit is positive amount in a 'debit' type transaction
                    'description' => 'Option "' . ucfirst(str_replace('_', ' ', $option['type'])) . '" pour annonce',
                    'reference' => 'OPT-' . strtoupper(Str::random(10)),
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }

        $this->command->info('✓ Transactions de crédits créées pour tous les vendeurs');
    }
}
