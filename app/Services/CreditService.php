<?php

namespace App\Services;

use App\Models\User;
use App\Models\CreditTransaction;
use Illuminate\Support\Str;

class CreditService
{
    /**
     * Ajouter des crédits au compte utilisateur
     */
    public function addCredits(User $user, int $amount, string $description = 'Achat de crédits')
    {
        $user->increment('credit_balance', $amount);

        CreditTransaction::create([
            'user_id' => $user->id,
            'type' => 'credit',
            'amount' => $amount,
            'reference' => 'CR-' . strtoupper(Str::random(12)),
            'description' => $description,
        ]);

        return $user->fresh();
    }

    /**
     * Débiter des crédits du compte utilisateur
     */
    public function debitCredits(User $user, int $amount, string $description = 'Consommation de crédits')
    {
        if ($user->credit_balance < $amount) {
            throw new \Exception('Solde de crédits insuffisant.');
        }

        $user->decrement('credit_balance', $amount);

        CreditTransaction::create([
            'user_id' => $user->id,
            'type' => 'debit',
            'amount' => $amount,
            'reference' => 'DB-' . strtoupper(Str::random(12)),
            'description' => $description,
        ]);

        return $user->fresh();
    }

    /**
     * Obtenir le solde de crédits
     */
    public function getBalance(User $user): int
    {
        return $user->credit_balance;
    }

    /**
     * Vérifier si l'utilisateur a assez de crédits
     */
    public function hasEnoughCredits(User $user, int $amount): bool
    {
        return $user->credit_balance >= $amount;
    }

    /**
     * Packs de crédits disponibles à l'achat
     */
    public function getAvailablePacks(): array
    {
        return [
            [
                'id' => 'pack_50',
                'credits' => 50,
                'price' => 2500, // FCFA
                'bonus' => 0,
                'label' => 'Pack Starter',
            ],
            [
                'id' => 'pack_150',
                'credits' => 150,
                'price' => 7000, // FCFA
                'bonus' => 10,
                'label' => 'Pack Premium',
                'popular' => true,
            ],
            [
                'id' => 'pack_500',
                'credits' => 500,
                'price' => 20000, // FCFA
                'bonus' => 50,
                'label' => 'Pack Business',
            ],
        ];
    }

    /**
     * Coût des options d'annonce en crédits
     */
    public function getOptionCosts(): array
    {
        return [
            'a_la_une' => 20,
            'urgent' => 15,
            'remontee' => 10,
        ];
    }
}
