<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnnulationCourse;
use Illuminate\Http\Request;

class AnnulationCourseController extends Controller
{
    /** Liste des annulations de course, filtrable par statut. */
    public function index(Request $request)
    {
        $statut = $request->get('statut', 'nouveau');

        $counts = [
            'nouveau' => AnnulationCourse::where('statut', 'nouveau')->count(),
            'traite'  => AnnulationCourse::where('statut', 'traite')->count(),
        ];

        $annulations = AnnulationCourse::with('partenaire')
            ->when(in_array($statut, ['nouveau', 'traite']), fn ($q) => $q->where('statut', $statut))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.annulations.index', compact('annulations', 'counts', 'statut'));
    }

    /** Marque une annulation comme traitée (ou nouveau). */
    public function traiter(AnnulationCourse $annulation)
    {
        $annulation->update([
            'statut' => $annulation->statut === 'traite' ? 'nouveau' : 'traite',
        ]);

        return back()->with('success', 'Annulation mise à jour.');
    }
}
