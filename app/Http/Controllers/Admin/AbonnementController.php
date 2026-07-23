<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AbonnementController extends Controller
{
    /**
     * Liste des abonnements, filtrable par famille.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $search = $request->get('search');
        $famille = in_array($request->get('famille'), Abonnement::familles())
            ? $request->get('famille')
            : null;

        $query = Abonnement::orderBy('famille')->orderBy('ordre');

        if ($famille) {
            $query->where('famille', $famille);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }

        $abonnements = $query->paginate($perPage)->withQueryString();

        // Compteurs par famille pour les onglets
        $counts = [];
        foreach (Abonnement::familles() as $f) {
            $counts[$f] = Abonnement::where('famille', $f)->count();
        }

        return view('admin.abonnements.index', compact('abonnements', 'perPage', 'search', 'famille', 'counts'));
    }

    public function create(Request $request)
    {
        $famille = in_array($request->get('famille'), Abonnement::familles())
            ? $request->get('famille')
            : Abonnement::FAMILLE_ECOMMERCE;

        return view('admin.abonnements.create', compact('famille'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $validated['actif'] = $request->has('actif');
        $validated['page_pro'] = $request->has('page_pro');
        $validated['ordre'] = (Abonnement::where('famille', $validated['famille'])->max('ordre') ?? 0) + 1;
        $validated['page_pro_personnalisable'] = (($validated['type'] ?? null) === Abonnement::TYPE_EXPERT);

        Abonnement::create($validated);

        return redirect()->route('admin.abonnements.index', ['famille' => $validated['famille']])
            ->with('success', 'Abonnement créé avec succès.');
    }

    public function show(Abonnement $abonnement)
    {
        return view('admin.abonnements.show', compact('abonnement'));
    }

    public function edit(Abonnement $abonnement)
    {
        $famille = $abonnement->famille;

        return view('admin.abonnements.edit', compact('abonnement', 'famille'));
    }

    public function update(Request $request, Abonnement $abonnement)
    {
        $validated = $this->validateData($request, $abonnement);

        $validated['actif'] = $request->has('actif');
        $validated['page_pro'] = $request->has('page_pro');
        $validated['page_pro_personnalisable'] = (($validated['type'] ?? null) === Abonnement::TYPE_EXPERT);

        $abonnement->update($validated);

        return redirect()->route('admin.abonnements.index', ['famille' => $abonnement->famille])
            ->with('success', 'Abonnement mis à jour avec succès.');
    }

    public function destroy(Abonnement $abonnement)
    {
        if ($abonnement->vendeurAbonnements()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer ce pack car il est utilisé par des vendeurs. Vous pouvez le désactiver à la place.');
        }

        $abonnement->delete();

        return redirect()->route('admin.abonnements.index')
            ->with('success', 'Abonnement supprimé avec succès.');
    }

    public function toggleStatus(Abonnement $abonnement)
    {
        $abonnement->update(['actif' => !$abonnement->actif]);

        $status = $abonnement->actif ? 'activé' : 'suspendu';
        return back()->with('success', "L'abonnement a été {$status} avec succès.");
    }

    /**
     * Paliers disponibles selon la famille.
     * - E-commerce : gratuit / basic / expert
     * - Autres familles (Services, Immobilier, Véhicules) : basic / expert
     */
    public static function paliersPourFamille(?string $famille): array
    {
        return $famille === Abonnement::FAMILLE_ECOMMERCE
            ? ['gratuit', 'basic', 'expert']
            : ['basic', 'expert'];
    }

    /**
     * Règles de validation communes create/update.
     * Le type (palier) est requis pour toutes les familles et unique par (type, famille).
     * Le nom est dérivé du type.
     */
    private function validateData(Request $request, ?Abonnement $abonnement = null): array
    {
        $famille = $request->get('famille');
        $paliers = self::paliersPourFamille($famille);

        $uniqueType = Rule::unique('abonnements', 'type')->where('famille', $famille);
        if ($abonnement) {
            $uniqueType->ignore($abonnement->id);
        }

        $rules = [
            'famille' => ['required', Rule::in(Abonnement::familles())],
            'type' => ['required', Rule::in($paliers), $uniqueType],
            'description' => 'required|string',
            'prix_mensuel' => 'required|numeric|min:0',
            'duree_jours' => 'required|integer|min:1',
            'commission' => 'required|numeric|min:0|max:100',
            'nombre_annonces' => 'required|integer|min:0',
            'limite_chiffre_affaires' => 'nullable|integer|min:0',
            'actif' => 'boolean',
            'page_pro' => 'boolean',
        ];

        $messages = [
            'type.unique' => 'Ce palier existe déjà pour cette famille.',
            'type.in' => 'Palier invalide pour cette famille.',
        ];

        $validated = $request->validate($rules, $messages);
        $validated['nom'] = ucfirst($validated['type']);

        return $validated;
    }
}
