<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AbonnementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 8);
        $search = $request->get('search');

        $query = Abonnement::orderBy('ordre');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }

        $abonnements = $query->paginate($perPage);
        return view('admin.abonnements.index', compact('abonnements', 'perPage', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $takenTypes = Abonnement::pluck('type')->toArray();
        $allTypes = ['gratuit', 'basic', 'expert'];
        $availableTypes = array_diff($allTypes, $takenTypes);
        
        return view('admin.abonnements.create', compact('availableTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:gratuit,basic,expert|unique:abonnements,type',
            'description' => 'required|string',
            'prix_mensuel' => 'required|numeric|min:0',
            'commission' => 'required|numeric|min:0|max:100',
            'nombre_annonces' => 'required|integer|min:0',
            'limite_chiffre_affaires' => 'nullable|integer|min:0',
            'actif' => 'boolean',
            'page_pro' => 'boolean',
        ]);

        $validated['actif'] = $request->has('actif');
        $validated['ordre'] = Abonnement::max('ordre') + 1;
        $validated['nom'] = ucfirst($validated['type']);
        
        // Harmonisation avec la méthode update
        $validated['page_pro_personnalisable'] = ($validated['type'] === Abonnement::TYPE_EXPERT);

        Abonnement::create($validated);

        return redirect()->route('admin.abonnements.index')
            ->with('success', 'Pack d\'abonnement créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Abonnement $abonnement)
    {
        return view('admin.abonnements.show', compact('abonnement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Abonnement $abonnement)
    {
        $takenTypes = Abonnement::where('id', '!=', $abonnement->id)->pluck('type')->toArray();
        $allTypes = ['gratuit', 'basic', 'expert'];
        $availableTypes = array_diff($allTypes, $takenTypes);
        
        return view('admin.abonnements.edit', compact('abonnement', 'availableTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Abonnement $abonnement)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:gratuit,basic,expert|unique:abonnements,type,' . $abonnement->id,
            'description' => 'required|string',
            'prix_mensuel' => 'required|numeric|min:0',
            'commission' => 'required|numeric|min:0|max:100',
            'nombre_annonces' => 'required|integer|min:0',
            'limite_chiffre_affaires' => 'nullable|integer|min:0',
        ]);

        $validated['actif'] = $request->has('actif');
        $validated['page_pro'] = $request->has('page_pro');
        $validated['page_pro_personnalisable'] = ($validated['type'] === Abonnement::TYPE_EXPERT);

        $validated['nom'] = ucfirst($validated['type']);

        $abonnement->update($validated);

        return redirect()->route('admin.abonnements.index')
            ->with('success', 'Pack d\'abonnement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Abonnement $abonnement)
    {
        if ($abonnement->vendeurAbonnements()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer ce pack car il est utilisé par des vendeurs. Vous pouvez le désactiver à la place.');
        }

        $abonnement->delete();

        return redirect()->route('admin.abonnements.index')
            ->with('success', 'Pack d\'abonnement supprimé avec succès.');
    }

    /**
     * Toggle the status of the pack.
     */
    public function toggleStatus(Abonnement $abonnement)
    {
        $abonnement->update(['actif' => !$abonnement->actif]);

        $status = $abonnement->actif ? 'activé' : 'suspendu';
        return back()->with('success', "Le pack d'abonnement a été {$status} avec succès.");
    }
}
