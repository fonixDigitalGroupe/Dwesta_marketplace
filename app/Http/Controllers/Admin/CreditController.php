<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreditPack;
use App\Models\CreditServiceConfig;
use App\Models\UserCredit;
use App\Models\CreditTransaction;
use App\Models\User;
use App\Services\CreditService;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function __construct(private CreditService $creditService) {}

    // =====================
    // Dashboard
    // =====================
    public function dashboard()
    {
        $totalCreditsVendus = CreditTransaction::where('type', 'achat')->sum('montant');
        $totalCreditDepenses = abs(CreditTransaction::where('type', 'depense')->sum('montant'));
        $totalPacks = CreditPack::actif()->count();
        $recentTransactions = CreditTransaction::with('user')->latest()->take(20)->get();

        return view('admin.credits.dashboard', compact(
            'totalCreditsVendus', 'totalCreditDepenses', 'totalPacks', 'recentTransactions'
        ));
    }

    // =====================
    // Credit Packs
    // =====================
    public function packsIndex(Request $request)
    {
        $query = CreditPack::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $search = $request->get('search');
        $perPage = $request->get('per_page', 8);
        $packs = $query->orderBy('ordre')->paginate($perPage)->withQueryString();

        return view('admin.credits.packs.index', compact('packs', 'perPage', 'search'));
    }

    public function packsCreate()
    {
        return view('admin.credits.packs.create');
    }

    public function packsStore(Request $request)
    {
        $validated = $request->validate([
            'nom'           => 'required|string|max:100',
            'description'   => 'nullable|string',
            'credits'       => 'required|integer|min:1',
            'bonus_credits' => 'required|integer|min:0',
            'prix'          => 'required|integer|min:0',
            'actif'         => 'boolean',
            'ordre'         => 'integer|min:0',
        ]);

        $validated['actif'] = $request->boolean('actif', true);

        CreditPack::create($validated);

        return redirect()->route('admin.credits.packs')->with('success', 'Pack de crédits créé avec succès.');
    }

    public function packsEdit(CreditPack $pack)
    {
        return view('admin.credits.packs.edit', compact('pack'));
    }

    public function packsUpdate(Request $request, CreditPack $pack)
    {
        $validated = $request->validate([
            'nom'           => 'required|string|max:100',
            'description'   => 'nullable|string',
            'credits'       => 'required|integer|min:1',
            'bonus_credits' => 'required|integer|min:0',
            'prix'          => 'required|integer|min:0',
            'actif'         => 'boolean',
            'ordre'         => 'integer|min:0',
        ]);

        $validated['actif'] = $request->boolean('actif');

        $pack->update($validated);

        return redirect()->route('admin.credits.packs')->with('success', 'Pack de crédits mis à jour avec succès.');
    }

    public function packsDestroy(CreditPack $pack)
    {
        $pack->delete();
        return redirect()->route('admin.credits.packs')->with('success', 'Pack de crédits supprimé avec succès.');
    }

    // =====================
    // Service Configs
    // =====================
    public function servicesIndex()
    {
        $services = CreditServiceConfig::orderBy('ordre')->get();
        return view('admin.credits.services.index', compact('services'));
    }

    public function servicesCreate()
    {
        return view('admin.credits.services.create');
    }

    public function servicesStore(Request $request)
    {
        $validated = $request->validate([
            'nom'           => 'required|string|max:100',
            'cle'           => 'required|string|max:50|unique:credit_service_configs,cle',
            'description'   => 'nullable|string',
            'credits_requis' => 'required|integer|min:1',
            'duree_jours'   => 'nullable|integer|min:1',
            'actif'         => 'boolean',
            'ordre'         => 'integer|min:0',
        ]);

        $validated['actif'] = $request->boolean('actif', true);
        $validated['duree_jours'] = $request->filled('duree_jours') ? $validated['duree_jours'] : null;

        CreditServiceConfig::create($validated);

        return redirect()->route('admin.credits.services');
    }

    public function servicesEdit(CreditServiceConfig $service)
    {
        return view('admin.credits.services.edit', compact('service'));
    }

    public function servicesUpdate(Request $request, CreditServiceConfig $service)
    {
        $validated = $request->validate([
            'nom'           => 'required|string|max:100',
            'description'   => 'nullable|string',
            'credits_requis' => 'required|integer|min:1',
            'duree_jours'   => 'nullable|integer|min:1',
            'actif'         => 'boolean',
            'ordre'         => 'integer|min:0',
        ]);

        $validated['actif'] = $request->boolean('actif');
        $validated['duree_jours'] = $request->filled('duree_jours') ? $validated['duree_jours'] : null;

        $service->update($validated);

        return redirect()->route('admin.credits.services');
    }

    public function servicesDestroy(CreditServiceConfig $service)
    {
        $service->delete();
        return redirect()->route('admin.credits.services');
    }

    // =====================
    // Attribution manuelle
    // =====================
    public function attribuerForm()
    {
        $users = User::orderBy('prenom')->get(['id', 'prenom', 'nom', 'email']);
        return view('admin.credits.attribuer', compact('users'));
    }

    public function attribuerStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'montant' => 'required|integer|min:1',
            'raison'  => 'required|string|max:255',
        ]);

        $user = User::findOrFail($request->user_id);
        $this->creditService->attribuerBonus($user, $request->montant, $request->raison);

        return redirect()->route('admin.credits.dashboard')->with('success', "{$request->montant} crédits attribués à {$user->prenom}.");
    }
}
