<?php

namespace App\Services;

use App\Models\Category;
use App\Models\CreditTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnnoncePaymentService
{
    /**
     * Vérifie si l'utilisateur peut payer pour la publication
     */
    public function canAffordPublication(User $user, Category $category): bool
    {
        if ($category->listing_price <= 0) {
            return true;
        }

        return $user->credit_balance >= $category->listing_price;
    }

    /**
     * Traite le paiement pour la publication si nécessaire
     * Retourne true si payé ou gratuit, false si échec
     */
    public function processPublicationPayment(User $user, Category $category, string $annonceReference): bool
    {
        if ($category->listing_price <= 0) {
            return true;
        }

        if ($user->credit_balance < $category->listing_price) {
            return false;
        }

        DB::transaction(function () use ($user, $category, $annonceReference) {
            $user->decrement('credit_balance', $category->listing_price);

            CreditTransaction::create([
                'user_id' => $user->id,
                'amount' => -$category->listing_price,
                'type' => 'debit',
                'description' => "Publication annonce {$annonceReference} (Catégorie: {$category->nom})",
                'reference' => 'PUB-' . time(),
            ]);
        });

        return true;
    }
}
