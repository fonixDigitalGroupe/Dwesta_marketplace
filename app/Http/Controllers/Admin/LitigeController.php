<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Litige;
use Illuminate\Http\Request;

class LitigeController extends Controller
{
    public function index(Request $request)
    {
        $statut = $request->get('statut', 'en_cours');

        $counts = [
            'en_cours' => Litige::where('statut', 'en_cours')->count(),
            'resolu'   => Litige::where('statut', 'resolu')->count(),
            'ferme'    => Litige::where('statut', 'ferme')->count(),
        ];

        $litiges = Litige::with(['reporter', 'reported', 'order.seller.user', 'order.buyer'])
            ->when(in_array($statut, ['en_cours', 'resolu', 'ferme']), fn($q) => $q->where('statut', $statut))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.litiges.index', compact('litiges', 'counts', 'statut'));
    }

    public function show(Litige $litige)
    {
        $litige->load(['reporter', 'reported', 'order.items.annonce.photos', 'order.seller.user', 'order.buyer']);

        // Le client a-t-il payé en ligne ? (remboursement possible)
        $paidOnline = $litige->order && !empty($litige->order->stripe_payment_intent_id);

        return view('admin.litiges.show', compact('litige', 'paidOnline'));
    }

    public function resolve(Request $request, Litige $litige)
    {
        $request->validate([
            'resolution' => 'required|string',
            'statut' => 'required|in:resolu,ferme',
            'action_financiere' => 'nullable|in:aucune,retour_vendeur',
        ]);

        $order = $litige->order;
        $messageRembours = '';

        // Retour de la commande au vendeur
        if ($request->input('action_financiere') === 'retour_vendeur' && $order) {
            $paidOnline = !empty($order->stripe_payment_intent_id);

            if ($paidOnline) {
                // 1) Remboursement du client via Stripe
                try {
                    app(\App\Services\StripeService::class)->refund($order->stripe_payment_intent_id);
                    $messageRembours = ' Client remboursé via Stripe.';
                } catch (\Throwable $e) {
                    \Log::error('Litige refund error', ['order' => $order->id, 'error' => $e->getMessage()]);
                    return back()->with('error', "Échec du remboursement Stripe : " . $e->getMessage());
                }

                // 2) Déduction du montant chez le vendeur (annulation du revenu en séquestre/dispo)
                if ($order->seller && $order->seller->user_id) {
                    $revenuVendeur = $order->total_produits - ($order->commission_plateforme ?? 0);
                    \App\Models\Transaction::create([
                        'order_id'       => $order->id,
                        'user_id'        => $order->seller->user_id,
                        'reference_externe' => 'RET-' . $order->reference,
                        'montant'        => -1 * $revenuVendeur,
                        'moyen_paiement' => 'wallet',
                        'statut'         => 'succes',
                        'wallet_status'  => 'none',
                        'metadata'       => ['type' => 'retour_litige', 'order_ref' => $order->reference],
                    ]);
                    $messageRembours .= ' Montant déduit du vendeur.';
                }
            } else {
                $messageRembours = " Le client n'avait pas payé en ligne : aucun remboursement nécessaire.";
            }

            // Marquer la commande comme annulée (retournée)
            $order->update(['statut' => \App\Models\Order::STATUT_ANNULE]);
        }

        $litige->update([
            'resolution' => $request->input('resolution'),
            'statut' => $request->input('statut'),
        ]);

        return redirect()->route('admin.litiges.show', $litige)
            ->with('success', 'Litige mis à jour.' . $messageRembours);
    }
}
