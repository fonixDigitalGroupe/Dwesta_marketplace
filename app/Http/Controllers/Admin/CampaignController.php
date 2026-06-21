<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Coupon;
use App\Models\Vendeur;
use App\Models\User;
use App\Notifications\PromotionCampaignNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CampaignController extends Controller
{
    /**
     * Historique des campagnes
     */
    public function index()
    {
        $campaigns = Campaign::with('coupon')->latest()->paginate(15);
        return view('admin.campaigns.index', compact('campaigns'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $coupons = Coupon::where('is_active', true)->get();
        return view('admin.campaigns.create', compact('coupons'));
    }

    /**
     * Envoi de la campagne
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'coupon_id' => 'required|exists:coupons,id',
            'target_type' => 'required|in:particulier,professionnel,all',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $coupon = Coupon::findOrFail($validated['coupon_id']);

        // Sélection des vendeurs cibles
        $query = Vendeur::where('actif', true);
        if ($validated['target_type'] !== 'all') {
            $query->where('type', $validated['target_type']);
        }

        $vendeurs = $query->with('user')->get();
        $users = $vendeurs->pluck('user')->filter();

        if ($users->isEmpty()) {
            return back()->with('error', 'Aucun vendeur trouvé pour cette cible.')->withInput();
        }

        // Création de l'enregistrement de campagne
        $campaign = Campaign::create([
            'coupon_id' => $coupon->id,
            'target_type' => $validated['target_type'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'sent_count' => $users->count(),
        ]);

        // Envoi massif de notifications
        Notification::send($users, new PromotionCampaignNotification($coupon, $validated['subject'], $validated['message']));

        return redirect()->route('promotions.index')->with('success', 'La campagne a été envoyée avec succès à ' . $users->count() . ' vendeurs.');
    }
}
