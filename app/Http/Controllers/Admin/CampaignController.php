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
        $coupons = Coupon::orderBy('code')->get();
        return view('admin.campaigns.create', compact('coupons'));
    }

    /**
     * Envoi de la campagne
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'coupon_id' => 'required|exists:coupons,id',
            'target_type' => 'required|in:particulier,professionnel,all',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date',
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
            'title' => $validated['title'],
            'coupon_id' => $coupon->id,
            'target_type' => $validated['target_type'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'sent_count' => $users->count(),
            'starts_at' => $validated['starts_at'],
            'ends_at' => $validated['ends_at'],
        ]);

        // Activer automatiquement le coupon lié
        $coupon->update(['is_active' => true]);

        // Envoi massif de notifications
        Notification::send($users, new PromotionCampaignNotification($coupon, $validated['subject'], $validated['message']));

        // Intégration Messagerie Interne
        $adminId = auth()->id();
        $discountLabel = $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value, 0) . ' FCFA';
        $catName = $coupon->category->nom ?? $coupon->categoryN1->nom ?? 'votre boutique';
        
        $fullContent = $validated['message'] . "\n\n" . 
                       "Code Promo : **" . $coupon->code . "**\n" .
                       "Réduction : **" . $discountLabel . "** sur la catégorie **" . $catName . "**";

        if ($campaign->starts_at || $campaign->ends_at) {
            $fullContent .= "\nValidité : **";
            if ($campaign->starts_at) $fullContent .= " du " . $campaign->starts_at->format('d/m/Y');
            if ($campaign->ends_at) $fullContent .= " au " . $campaign->ends_at->format('d/m/Y');
            $fullContent .= "**";
        }

        $fullContent .= "\n\n" . 
                       "[Créer une nouvelle annonce](/annonces/create)\n" .
                       "[Gérer mes annonces](/vendeur/mes-annonces)";

        foreach ($users as $user) {
            // Trouver ou créer la conversation entre l'admin et le vendeur
            $conversation = \App\Models\Conversation::where(function($q) use ($adminId, $user) {
                $q->where('user1_id', $adminId)->where('user2_id', $user->id);
            })->orWhere(function($q) use ($adminId, $user) {
                $q->where('user1_id', $user->id)->where('user2_id', $adminId);
            })->first();

            if (!$conversation) {
                $conversation = \App\Models\Conversation::create([
                    'user1_id' => $adminId,
                    'user2_id' => $user->id,
                    'last_message_at' => now(),
                ]);
            } else {
                $conversation->update(['last_message_at' => now()]);
            }

            // Créer le message
            \App\Models\Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $adminId,
                'content' => $fullContent,
                'image_path' => $coupon->banner_image,
                'campaign_id' => $campaign->id,
            ]);
        }

        return redirect()->route('admin.promotions.index')->with('success', 'La campagne a été envoyée avec succès à ' . $users->count() . ' vendeurs (Email, Notification et Messagerie).');
    }
    public function edit(Campaign $campaign)
    {
        $coupons = Coupon::orderBy('code')->get();
        return view('admin.campaigns.edit', compact('campaign', 'coupons'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'coupon_id' => 'required|exists:coupons,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date',
        ]);

        $campaign->update($validated);

        return redirect()->route('admin.promotions.index')->with('success', 'La campagne a été mise à jour dans l\'historique.');
    }

    public function destroy(Campaign $campaign)
    {
        // 1. Si le coupon n'a plus d'autres campagnes après suppression, le désactiver
        //    et rétablir le prix initial des annonces adhérentes.
        if ($campaign->coupon) {
            $remainingCampaigns = $campaign->coupon->campaigns()->where('id', '!=', $campaign->id)->count();
            if ($remainingCampaigns === 0) {
                $campaign->coupon->update(['is_active' => false]);
                $campaign->coupon->retablirPrixAnnonces();
            }
        }

        // 2. Supprimer tous les messages associés dans la messagerie
        $campaign->messages()->delete();
        
        // 3. Supprimer la campagne
        $campaign->delete();

        // 4. Vider le cache pour mettre à jour le header et les landing pages
        \Illuminate\Support\Facades\Artisan::call('cache:clear');

        return redirect()->route('admin.promotions.index')->with('success', 'La campagne a été supprimée, le coupon associé a été désactivé et le cache du site a été vidé.');
    }
}
