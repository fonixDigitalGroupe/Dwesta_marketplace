<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Annonce;
use App\Models\AnnonceVariante;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Obtenir le panier actuel (depuis la base si connecté, sinon session)
     */
    public function getCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }

        $sessionId = Session::getId();
        return Cart::firstOrCreate(['session_id' => $sessionId, 'user_id' => null]);
    }

    /**
     * Ajouter un article au panier
     */
    public function addItem($annonceId, $varianteId = null, $quantite = 1)
    {
        $cart = $this->getCart();

        $item = $cart->items()->where('annonce_id', $annonceId)
            ->where('annonce_variante_id', $varianteId)
            ->first();

        if ($item) {
            $item->quantite += $quantite;
            $item->save();
        } else {
            $item = $cart->items()->create([
                'annonce_id' => $annonceId,
                'annonce_variante_id' => $varianteId,
                'quantite' => $quantite
            ]);
        }

        return $item;
    }

    /**
     * Mettre à jour la quantité d'un article
     */
    public function updateQuantity($itemId, $quantite)
    {
        $cart = $this->getCart();
        $item = $cart->items()->findOrFail($itemId);

        if ($quantite <= 0) {
            $item->delete();
            return null;
        }

        $item->quantite = $quantite;
        $item->save();

        return $item;
    }

    /**
     * Supprimer un article
     */
    public function removeItem($itemId)
    {
        $cart = $this->getCart();
        $cart->items()->where('id', $itemId)->delete();
    }

    /**
     * Vider le panier
     */
    public function clear()
    {
        $cart = $this->getCart();
        $cart->items()->delete();
    }

    /**
     * Obtenir le contenu du panier regroupé par vendeur
     */
    public function getContentGroupedBySeller()
    {
        $cart = $this->getCart();
        $items = $cart->items()->with(['annonce.vendeur.user', 'variante'])->get();

        return $items->groupBy(function ($item) {
            return $item->annonce->vendeur_id;
        });
    }

    /**
     * Calculer le sous-total du panier
     */
    public function getSubtotal()
    {
        $cart = $this->getCart();
        $items = $cart->items()->with(['annonce', 'variante'])->get();

        return $items->sum(function ($item) {
            // prix_affiche = prix remisé si la promo/campagne est active, sinon prix initial.
            $prixBase = $item->annonce->prix_affiche;
            $prixExtra = $item->variante ? $item->variante->prix_supplementaire : 0;
            return ($prixBase + $prixExtra) * $item->quantite;
        });
    }

    /**
     * Compter le nombre d'articles
     */
    public function getItemsCount()
    {
        $cart = $this->getCart();
        return $cart->items()->sum('quantite');
    }
}
