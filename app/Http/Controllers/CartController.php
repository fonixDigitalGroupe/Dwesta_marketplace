<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Afficher le panier
     */
    public function index()
    {
        $cartGrouped = $this->cartService->getContentGroupedBySeller();
        $subtotal = $this->cartService->getSubtotal();
        
        return view('cart.index', compact('cartGrouped', 'subtotal'));
    }

    /**
     * Ajouter un article au panier
     */
    public function store(Request $request)
    {
        $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'variante_id' => 'nullable|exists:annonce_variantes,id',
            'quantite' => 'integer|min:1'
        ]);

        $this->cartService->addItem(
            $request->annonce_id,
            $request->variante_id,
            $request->quantite ?? 1
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Article ajouté au panier',
                'cartCount' => $this->cartService->getItemsCount()
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Article ajouté au panier !');
    }

    /**
     * Mettre à jour la quantité
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantite' => 'required|integer|min:0'
        ]);

        $this->cartService->updateQuantity($id, $request->quantite);

        return redirect()->route('cart.index')->with('success', 'Panier mis à jour');
    }

    /**
     * Supprimer un article
     */
    public function destroy($id)
    {
        $this->cartService->removeItem($id);

        return redirect()->route('cart.index')->with('success', 'Article supprimé');
    }

    /**
     * Vider le panier
     */
    public function clear()
    {
        $this->cartService->clear();

        return redirect()->route('cart.index')->with('success', 'Panier vidé');
    }
}
