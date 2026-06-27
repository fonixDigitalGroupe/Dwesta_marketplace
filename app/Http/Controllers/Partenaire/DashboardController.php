<?php

namespace App\Http\Controllers\Partenaire;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /** Tableau de bord chauffeur : carte plein écran + statut + missions. */
    public function home()
    {
        $user    = Auth::user();
        $profil  = $this->profil($user);

        if (! $profil) {
            return redirect()->route('partenaire.permissions');
        }

        $livreurId = $user->estLivreur() ? $user->livreur->id : null;
        $colonne   = $user->estLivreur() ? 'livreur_id' : 'transporteur_id';
        $commission = $user->estLivreur() ? 'commission_livreur' : 'commission_transporteur';

        $gainsJour = Order::where($colonne, $profil->id)
            ->where('statut', Order::STATUT_LIVRE)
            ->whereDate('updated_at', today())
            ->sum($commission);

        return view('partenaire.home', [
            'user'        => $user,
            'type'        => $user->estLivreur() ? 'livreur' : 'transporteur',
            'enLigne'     => (bool) $profil->en_ligne,
            'verifie'     => $profil->statut_verification === 'verifie',
            'gainsJour'   => (int) $gainsJour,
            'position'    => ['lat' => $user->latitude, 'lng' => $user->longitude],
        ]);
    }

    /** Bascule en ligne / hors ligne (AJAX). */
    public function toggleOnline(Request $request)
    {
        $profil = $this->profil(Auth::user());
        abort_unless($profil, 403);

        $profil->forceFill(['en_ligne' => ! $profil->en_ligne])->save();

        return response()->json(['en_ligne' => (bool) $profil->en_ligne]);
    }

    /** Reçoit la position GPS poussée par le navigateur (AJAX). */
    public function updatePosition(Request $request)
    {
        $data = $request->validate([
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
        ]);

        Auth::user()->forceFill([
            'latitude'            => $data['lat'],
            'longitude'           => $data['lng'],
            'position_updated_at' => now(),
        ])->save();

        return response()->json(['ok' => true]);
    }

    /** Missions disponibles pour le partenaire (AJAX), selon son métier. */
    public function missions()
    {
        $user   = Auth::user();
        $profil = $this->profil($user);
        abort_unless($profil, 403);

        // Hors ligne : aucune mission proposée.
        if (! $profil->en_ligne) {
            return response()->json(['en_ligne' => false, 'missions' => []]);
        }

        if ($user->estLivreur()) {
            $statuts  = [Order::STATUT_PRET, Order::STATUT_DISPONIBLE];
            $colonne  = 'livreur_id';
            $champCom = 'commission_livreur';
        } else {
            $statuts  = [Order::STATUT_PRET];
            $colonne  = 'transporteur_id';
            $champCom = 'commission_transporteur';
        }

        $missions = Order::with('seller.user')
            ->whereIn('statut', $statuts)
            ->whereNull($colonne)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(fn (Order $o) => [
                'id'          => $o->id,
                'reference'   => $o->reference,
                'montant'     => (int) ($o->{$champCom} ?: $o->frais_port ?: 0),
                'ramassage'   => $this->labelVendeur($o),
                'destination' => $o->adresse_livraison ?: 'Adresse client',
            ]);

        return response()->json(['en_ligne' => true, 'missions' => $missions]);
    }

    /* ------------------------------------------------------------------ Utils */

    /** Renvoie le profil logistique (Livreur ou Transporteur) de l'utilisateur. */
    private function profil($user)
    {
        if (! $user) {
            return null;
        }

        return $user->estLivreur() ? $user->livreur : ($user->estTransporteur() ? $user->transporteur : null);
    }

    private function labelVendeur(Order $o): string
    {
        $u = $o->seller?->user;
        $nom = trim(($u->prenom ?? '') . ' ' . ($u->nom ?? ''));

        return $nom !== '' ? $nom : 'Point de collecte';
    }
}
