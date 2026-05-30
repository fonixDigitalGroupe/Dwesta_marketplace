<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointRelais;
use App\Models\User;
use Illuminate\Http\Request;

class PointRelaisController extends Controller
{
    /**
     * Dashboard for Pickup Point managers.
     */
    /**
     * Dashboard for Pickup Point managers.
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        // Get pickup points managed by this user
        $poids_relais = $user->managedPointRelais;
        $pointIds = $poids_relais->pluck('id');

        // Statistiques
        $stats = [
            'en_attente' => \App\Models\Order::whereIn('destination_point_relais_id', $pointIds)
                ->where('statut', \App\Models\Order::STATUT_EN_ROUTE)
                ->count(),
            'en_stock' => \App\Models\Order::whereIn('destination_point_relais_id', $pointIds)
                ->where('statut', \App\Models\Order::STATUT_DISPONIBLE)
                ->count(),
            'total_livre' => \App\Models\Order::whereIn('destination_point_relais_id', $pointIds)
                ->where('statut', \App\Models\Order::STATUT_LIVRE)
                ->count(),
            'commissions' => \App\Models\Order::whereIn('destination_point_relais_id', $pointIds)
                ->where('statut', \App\Models\Order::STATUT_LIVRE)
                ->sum('commission_point_relais'),
        ];

        // Commandes en cours de réception (viennent vers le point relais)
        $incomingOrders = \App\Models\Order::whereIn('destination_point_relais_id', $pointIds)
            ->where('statut', \App\Models\Order::STATUT_EN_ROUTE)
            ->with(['buyer', 'seller'])
            ->latest()
            ->limit(10)
            ->get();

        // Commandes prêtes pour retrait client (déjà au point relais)
        $readyOrders = \App\Models\Order::whereIn('destination_point_relais_id', $pointIds)
            ->where('statut', \App\Models\Order::STATUT_DISPONIBLE)
            ->with(['buyer', 'seller', 'items.annonce'])
            ->latest()
            ->limit(10)
            ->get();

        // Commandes livrées (Historique)
        $deliveredOrders = \App\Models\Order::whereIn('destination_point_relais_id', $pointIds)
            ->where('statut', \App\Models\Order::STATUT_LIVRE)
            ->with(['buyer', 'seller', 'items.annonce'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.point_relais.dashboard', compact('poids_relais', 'stats', 'incomingOrders', 'readyOrders', 'deliveredOrders', 'user'));
    }

    /**
     * Confirmer la réception d'une commande au point relais.
     */
    public function receiveOrder(\App\Models\Order $order)
    {
        // Vérifier si l'utilisateur gère ce point relais
        if (!auth()->user()->managedPointRelais->contains($order->destination_point_relais_id)) {
            abort(403);
        }

        $order->update(['statut' => \App\Models\Order::STATUT_DISPONIBLE]);

        return back()->with('success', 'Colis réceptionné. Le client va être informé de la disponibilité.');
    }

    /**
     * Confirmer la remise de la commande au client.
     */
    public function deliverOrder(\App\Models\Order $order)
    {
        // Vérifier si l'utilisateur gère ce point relais
        if (!auth()->user()->managedPointRelais->contains($order->destination_point_relais_id)) {
            abort(403);
        }

        if ($order->statut === \App\Models\Order::STATUT_LIVRE) {
            return back()->with('error', 'Commande déjà livrée.');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($order) {
            // Mettre à jour le statut
            $order->update(['statut' => \App\Models\Order::STATUT_LIVRE]);

            // Verser la commission au Point Relais (Utilisateur connecté)
            if ($order->commission_point_relais > 0) {
                \App\Models\Transaction::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->id(), // On paye le manager qui effectue l'action
                    'reference_externe' => 'COM-REL-' . $order->reference,
                    'montant' => $order->commission_point_relais,
                    'moyen_paiement' => 'commission',
                    'statut' => 'succes',
                    'wallet_status' => \App\Models\Transaction::STATUS_AVAILABLE,
                    'release_at' => now(),
                    'metadata' => [
                        'type' => 'commission_point_relais',
                        'point_relais_id' => $order->destination_point_relais_id
                    ]
                ]);

                // Mettre à jour la balance du vendeur (si géré par colonne)
                // Note: Si le système utilise une somme dynamique des transactions, cette étape n'est pas requise.
                // App\Models\User::class montre 'credit_balance' dans fillable, donc on incrémente.
                $user = auth()->user();
                $user->increment('credit_balance', $order->commission_point_relais);
            }
        });

        return back()->with('success', 'Commande remise au client. Commission créditée.');
    }

    /**
     * Show form for manager to edit their point relais.
     */
    public function editSelf(PointRelais $point_relais)
    {
        // Verify ownership
        if (!auth()->user()->managedPointRelais->contains($point_relais->id)) {
            abort(403);
        }

        return view('admin.point_relais.edit_self', compact('point_relais'));
    }

    /**
     * Update method for manager.
     */
    public function updateSelf(Request $request, PointRelais $point_relais)
    {
        // Verify ownership
        if (!auth()->user()->managedPointRelais->contains($point_relais->id)) {
            abort(403);
        }

        $validated = $request->validate([
            'telephone' => 'nullable|string|max:20',
            'horaires' => 'nullable|string',
            'google_maps_url' => 'nullable|url',
        ]);

        if ($request->filled('full_telephone')) {
            $validated['telephone'] = $request->full_telephone;
        }

        $point_relais->update($validated);

        return redirect()->route('admin.prive.point-relais.dashboard')->with('success', 'Informations mises à jour.');
    }

    /**
     * Display a listing of pickup points (Admin).
     */
    public function index()
    {
        $points = PointRelais::with('users')->paginate(8);
        return view('admin.point_relais.index', compact('points'));
    }

    /**
     * Show the form for creating a new pickup point (Admin).
     */
    public function create()
    {
        $users = User::role('point relais')->get();
        return view('admin.point_relais.create', compact('users'));
    }

    /**
     * Store a newly created pickup point.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string',
            'pays' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'telephone' => 'nullable|string|max:20',
            'google_maps_url' => 'nullable|url',
            'horaires' => 'nullable|string',
            'managers' => 'nullable|array',
            'managers.*' => 'exists:users,id',
            'est_point_special' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['est_point_special'] = $request->has('est_point_special');
        
        if ($request->filled('full_telephone')) {
            $validated['telephone'] = $request->full_telephone;
        }

        $point = PointRelais::create($validated);

        if (!empty($validated['managers'])) {
            $point->users()->sync($validated['managers']);
        }

        return redirect()->route('admin.point-relais.index')->with('success', 'Point relais créé avec succès.');
    }

    /**
     * Show the form for editing.
     */
    public function edit(PointRelais $point_relais)
    {
        $users = User::role('point relais')->get();
        return view('admin.point_relais.edit', compact('point_relais', 'users'));
    }

    /**
     * Update the pickup point.
     */
    public function update(Request $request, PointRelais $point_relais)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string',
            'pays' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'telephone' => 'nullable|string|max:20',
            'google_maps_url' => 'nullable|url',
            'horaires' => 'nullable|string',
            'managers' => 'nullable|array',
            'managers.*' => 'exists:users,id',
            'est_point_special' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['est_point_special'] = $request->has('est_point_special');

        if ($request->filled('full_telephone')) {
            $validated['telephone'] = $request->full_telephone;
        }

        $point_relais->update($validated);

        if (isset($validated['managers'])) {
            $point_relais->users()->sync($validated['managers']);
        }

        return redirect()->route('admin.point-relais.index')->with('success', 'Point relais mis à jour avec succès.');
    }

    /**
     * Remove the pickup point.
     */
    public function destroy(PointRelais $point_relais)
    {
        $point_relais->delete();
        return redirect()->route('admin.point-relais.index')->with('success', 'Point relais supprimé.');
    }
}
