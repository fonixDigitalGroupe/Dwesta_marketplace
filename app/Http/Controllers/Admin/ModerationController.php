<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\Signalement;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class ModerationController extends Controller
{
    /**
     * Page de modération : avis en attente + annonces signalées.
     */
    public function index()
    {
        $avisEnAttente = Avis::enAttente()
            ->with(['annonce', 'user'])
            ->latest()
            ->paginate(10, ['*'], 'avis_page');

        // Défensif : la table signalements peut ne pas encore exister (migration non lancée en prod).
        $signalementsTablePresente = Schema::hasTable('signalements');

        $signalementsNouveauCount = 0;
        $signalementsTraiteCount = 0;

        if ($signalementsTablePresente) {
            $signalements = Signalement::with(['annonce', 'reporter'])
                ->where('statut', 'nouveau')
                ->latest()
                ->paginate(10, ['*'], 'sig_page');

            $signalementsNouveauCount = Signalement::where('statut', 'nouveau')->count();
            $signalementsTraiteCount = Signalement::where('statut', 'traite')->count();
        } else {
            $signalements = new LengthAwarePaginator([], 0, 10, 1, [
                'path' => request()->url(),
                'pageName' => 'sig_page',
            ]);
        }

        $avisEnAttenteCount = $avisEnAttente->total();

        return view('admin.moderation.index', compact(
            'avisEnAttente',
            'signalements',
            'signalementsTablePresente',
            'avisEnAttenteCount',
            'signalementsNouveauCount',
            'signalementsTraiteCount'
        ));
    }

    /**
     * Marque un signalement comme traité.
     */
    public function traiterSignalement(Signalement $signalement)
    {
        $signalement->update(['statut' => 'traite']);

        return back()->with('success', 'Signalement marqué comme traité.');
    }

    /**
     * Rejette (ignore) un signalement.
     */
    public function rejeterSignalement(Signalement $signalement)
    {
        $signalement->update(['statut' => 'rejete']);

        return back()->with('success', 'Signalement rejeté.');
    }
}
