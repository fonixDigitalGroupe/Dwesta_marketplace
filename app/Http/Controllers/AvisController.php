<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Avis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AvisController extends Controller
{
    use AuthorizesRequests;
    /**
     * Affiche les avis laissés par l'utilisateur connecté
     */
    public function mesAvis()
    {
        $avis = Avis::where('user_id', Auth::id())
            ->with(['annonce'])
            ->latest()
            ->paginate(15);

        return view('account.avis', compact('avis'));
    }

    /**
     * Affiche les avis d'une annonce
     */
    public function index(Annonce $annonce)
    {
        $avis = $annonce->avisApprouves()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('avis.index', compact('annonce', 'avis'));
    }

    /**
     * Affiche le formulaire de création d'un avis
     */
    public function create(Annonce $annonce)
    {
        // Vérifier que l'utilisateur est connecté (géré par middleware mais double-contrôle)
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour laisser un avis.');
        }

        // Vérifier que l'utilisateur n'a pas déjà laissé un avis pour cette annonce
        $existingAvis = Avis::where('annonce_id', $annonce->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingAvis) {
            return redirect()->route('annonces.show', $annonce)
                ->with('error', 'Vous avez déjà laissé un avis pour cette annonce.');
        }

        return view('avis.create', compact('annonce'));
    }

    /**
     * Enregistre un nouvel avis
     */
    public function store(Request $request, Annonce $annonce)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour laisser un avis.');
        }

        // Vérifier que l'utilisateur n'a pas déjà laissé un avis
        $existingAvis = Avis::where('annonce_id', $annonce->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingAvis) {
            return back()->withInput()
                ->with('error', 'Vous avez déjà laissé un avis pour cette annonce.');
        }

        // Vérifier que l'utilisateur a acheté cette annonce et que la commande est livrée
        $hasDeliveredOrder = \App\Models\Order::where('user_id', Auth::id())
            ->where('statut', \App\Models\Order::STATUT_LIVRE)
            ->whereHas('items', function ($query) use ($annonce) {
                $query->where('annonce_id', $annonce->id);
            })
            ->exists();

        if (!$hasDeliveredOrder) {
            return redirect()->route('annonces.show', $annonce)
                ->with('error', 'Vous ne pouvez laisser un avis que sur un produit que vous avez acheté et qui a été livré.');
        }

        // Validation
        $validated = $request->validate([
            'note' => ['required', 'integer', 'min:1', 'max:5'],
            'commentaire' => ['required', 'string', 'min:10', 'max:1000'],
            'photos' => ['nullable', 'array', 'max:3'],
            'photos.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'], // 2 Mo max par photo
        ]);

        try {
            $photos = [];
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('avis/photos', 'public');
                    $photos[] = $path;
                }
            }

            $avis = Avis::create([
                'annonce_id' => $annonce->id,
                'user_id' => Auth::id(),
                'note' => $validated['note'],
                'commentaire' => $validated['commentaire'],
                'photos' => !empty($photos) ? $photos : null,
                'statut' => Avis::STATUT_APPROUVE, // Publié directement
            ]);

            return redirect()->route('annonces.show', $annonce)
                ->with('success', 'Votre avis a été soumis et sera publié après modération.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de l\'avis: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la soumission de votre avis.');
        }
    }

    /**
     * Affiche les avis en attente de modération (admin)
     */
    public function moderation()
    {
        $this->authorize('viewAny', Avis::class); // Vérifier que l'utilisateur est admin

        $avisEnAttente = Avis::enAttente()
            ->with(['annonce', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.avis.moderation', compact('avisEnAttente'));
    }

    /**
     * Approuve un avis (admin)
     */
    public function approve(Avis $avis)
    {
        $this->authorize('update', $avis); // Vérifier que l'utilisateur est admin

        $avis->update([
            'statut' => Avis::STATUT_APPROUVE,
            'modere_par' => Auth::id(),
            'modere_le' => now(),
        ]);

        return back()->with('success', 'Avis approuvé avec succès.');
    }

    /**
     * Rejette un avis (admin)
     */
    public function reject(Request $request, Avis $avis)
    {
        $this->authorize('update', $avis); // Vérifier que l'utilisateur est admin

        $validated = $request->validate([
            'raison_rejet' => ['required', 'string', 'max:500'],
        ]);

        $avis->update([
            'statut' => Avis::STATUT_REJETE,
            'raison_rejet' => $validated['raison_rejet'],
            'modere_par' => Auth::id(),
            'modere_le' => now(),
        ]);

        return back()->with('success', 'Avis rejeté avec succès.');
    }
}
