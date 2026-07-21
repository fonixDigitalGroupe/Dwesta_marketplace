<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\Signalement;
use Illuminate\Http\Request;

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

        $signalements = Signalement::with(['annonce', 'reporter'])
            ->where('statut', 'nouveau')
            ->latest()
            ->paginate(10, ['*'], 'sig_page');

        $signalementsCount = Signalement::where('statut', 'nouveau')->count();

        return view('admin.moderation.index', compact('avisEnAttente', 'signalements', 'signalementsCount'));
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
