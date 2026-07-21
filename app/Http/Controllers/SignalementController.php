<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Signalement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SignalementController extends Controller
{
    /**
     * Enregistre un signalement d'annonce depuis le site public.
     */
    public function store(Request $request, Annonce $annonce)
    {
        $validated = $request->validate([
            'motif' => ['required', Rule::in(array_keys(Signalement::MOTIFS))],
            'description' => ['nullable', 'string', 'max:2000'],
            'email' => ['nullable', 'email', 'max:255'],
        ], [
            'motif.required' => 'Veuillez choisir un motif de signalement.',
            'motif.in' => 'Le motif sélectionné est invalide.',
        ]);

        Signalement::create([
            'annonce_id' => $annonce->id,
            'reporter_id' => Auth::id(),
            'email' => $validated['email'] ?? (Auth::user()->email ?? null),
            'motif' => $validated['motif'],
            'description' => $validated['description'] ?? null,
            'statut' => 'nouveau',
        ]);

        return back()->with('success', 'Merci, votre signalement a bien été transmis à notre équipe de modération.');
    }
}
