<?php

namespace App\Http\Controllers\Partenaire;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    /** Écran profil : identité, véhicule, statut KYC. */
    public function profil()
    {
        $user   = Auth::user();
        $profil = $this->profil_($user);

        if (! $profil) {
            return redirect()->route('partenaire.permissions');
        }

        return view('partenaire.profil', [
            'user'    => $user,
            'profil'  => $profil,
            'type'    => $user->estLivreur() ? 'livreur' : 'transporteur',
        ]);
    }

    /** Écran gains : solde (commissions cumulées) + historique des courses. */
    public function gains()
    {
        $user   = Auth::user();
        $profil = $this->profil_($user);

        if (! $profil) {
            return redirect()->route('partenaire.permissions');
        }

        $estLivreur = $user->estLivreur();
        $colonne    = $estLivreur ? 'livreur_id' : 'transporteur_id';
        $champCom   = $estLivreur ? 'commission_livreur' : 'commission_transporteur';
        $statutsOk  = $estLivreur ? [Order::STATUT_LIVRE] : [Order::STATUT_DISPONIBLE, Order::STATUT_LIVRE];

        $base = Order::where($colonne, $profil->id)->whereIn('statut', $statutsOk);

        $total = (clone $base)->sum($champCom);
        $jour  = (clone $base)->whereDate('updated_at', today())->sum($champCom);

        $courses = (clone $base)
            ->orderByDesc('updated_at')
            ->limit(25)
            ->get(['id', 'reference', $champCom . ' as commission', 'updated_at']);

        return view('partenaire.gains', [
            'soldeTotal' => (int) $total,
            'gainsJour'  => (int) $jour,
            'courses'    => $courses,
        ]);
    }

    private function profil_($user)
    {
        if (! $user) {
            return null;
        }

        return $user->estLivreur() ? $user->livreur : ($user->estTransporteur() ? $user->transporteur : null);
    }
}
