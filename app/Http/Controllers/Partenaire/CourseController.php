<?php

namespace App\Http\Controllers\Partenaire;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /** Accepte une mission : assignation + passage « en route ». */
    public function accept(Request $request, Order $order)
    {
        $user   = Auth::user();
        $profil = $this->profil($user);
        abort_unless($profil, 403);

        // Le partenaire ne peut avoir qu'une course active à la fois.
        if ($this->courseActive($user, $profil)) {
            return response()->json(['message' => 'Vous avez déjà une course en cours.'], 422);
        }

        $estLivreur = $user->estLivreur();
        $colonne    = $estLivreur ? 'livreur_id' : 'transporteur_id';
        $statutsOk  = $estLivreur ? [Order::STATUT_PRET, Order::STATUT_DISPONIBLE] : [Order::STATUT_PRET];

        // Verrouillage : on n'assigne que si la course est toujours libre.
        $assignee = DB::transaction(function () use ($order, $colonne, $statutsOk, $profil, $estLivreur) {
            $frais = Order::whereKey($order->id)->lockForUpdate()->first();

            if (! $frais || ! in_array($frais->statut, $statutsOk, true) || ! is_null($frais->{$colonne})) {
                return null;
            }

            $frais->forceFill([
                $colonne => $profil->id,
                'statut' => Order::STATUT_EN_ROUTE,
                'code_livraison' => $estLivreur ? str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT) : $frais->code_livraison,
            ])->save();

            return $frais;
        });

        if (! $assignee) {
            return response()->json(['message' => 'Cette course vient d\'être prise par un autre partenaire.'], 409);
        }

        return response()->json(['course' => $this->presente($assignee, $user)]);
    }

    /** Renvoie la course active du partenaire (pour reprendre après rechargement). */
    public function active()
    {
        $user   = Auth::user();
        $profil = $this->profil($user);
        abort_unless($profil, 403);

        $course = $this->courseActive($user, $profil);

        return response()->json(['course' => $course ? $this->presente($course, $user) : null]);
    }

    /** Termine la course : livré (livreur) ou déposé au relais (transporteur). */
    public function complete(Request $request, Order $order)
    {
        $user   = Auth::user();
        $profil = $this->profil($user);
        abort_unless($profil, 403);

        $estLivreur = $user->estLivreur();
        $colonne    = $estLivreur ? 'livreur_id' : 'transporteur_id';

        // La course doit appartenir au partenaire et être en route.
        if ($order->{$colonne} !== $profil->id || $order->statut !== Order::STATUT_EN_ROUTE) {
            return response()->json(['message' => 'Course introuvable ou déjà terminée.'], 422);
        }

        if ($estLivreur) {
            // Vérification du code de livraison remis par le client.
            $request->validate(['code' => ['required', 'digits:4']]);

            if ($order->code_livraison && $request->code !== $order->code_livraison) {
                return response()->json(['message' => 'Code de livraison incorrect.'], 422);
            }

            $this->livrer($order);

            return response()->json(['ok' => true, 'message' => 'Livraison confirmée. Fonds libérés pour le vendeur.']);
        }

        // Transporteur : dépôt au point relais.
        $order->forceFill(['statut' => Order::STATUT_DISPONIBLE])->save();

        return response()->json(['ok' => true, 'message' => 'Colis déposé au point relais.']);
    }

    /* ------------------------------------------------------------------ Utils */

    private function livrer(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $order->forceFill(['statut' => Order::STATUT_LIVRE])->save();

            // Libération des fonds séquestrés vers le vendeur (même logique que le dashboard livreur).
            $transactions = Transaction::where('order_id', $order->id)
                ->where('wallet_status', Transaction::STATUS_PENDING)
                ->get();

            foreach ($transactions as $tx) {
                $tx->update([
                    'wallet_status' => Transaction::STATUS_AVAILABLE,
                    'release_at'    => now(),
                ]);

                if ($tx->user) {
                    $tx->user->increment('credit_balance', $tx->montant);
                }
            }
        });
    }

    /** Course en cours (en_route) assignée à ce partenaire, le cas échéant. */
    private function courseActive($user, $profil): ?Order
    {
        $colonne = $user->estLivreur() ? 'livreur_id' : 'transporteur_id';

        return Order::with('seller.user')
            ->where($colonne, $profil->id)
            ->where('statut', Order::STATUT_EN_ROUTE)
            ->latest('updated_at')
            ->first();
    }

    private function presente(Order $o, $user): array
    {
        $u   = $o->seller?->user;
        $nom = trim(($u->prenom ?? '') . ' ' . ($u->nom ?? ''));
        $champCom = $user->estLivreur() ? 'commission_livreur' : 'commission_transporteur';

        return [
            'id'             => $o->id,
            'reference'      => $o->reference,
            'montant'        => (int) ($o->{$champCom} ?: $o->frais_port ?: 0),
            'ramassage'      => $nom !== '' ? $nom : 'Point de collecte',
            'destination'    => $o->adresse_livraison ?: 'Adresse client',
            'type'           => $user->estLivreur() ? 'livreur' : 'transporteur',
            // Exposé pour la démo (en prod : envoyé au client par SMS).
            'code_livraison' => $o->code_livraison,
        ];
    }

    private function profil($user)
    {
        if (! $user) {
            return null;
        }

        return $user->estLivreur() ? $user->livreur : ($user->estTransporteur() ? $user->transporteur : null);
    }
}
