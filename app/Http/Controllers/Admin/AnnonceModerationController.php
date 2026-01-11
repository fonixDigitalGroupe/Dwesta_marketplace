<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceModerationController extends Controller
{
    public function index()
    {
        $annonces = Annonce::where('statut', 'en_attente')->with('vendeur.user')->latest()->paginate(10);
        return view('admin.annonces.index', compact('annonces'));
    }

    public function approve(Annonce $annonce)
    {
        $annonce->update(['statut' => 'actif']); // Assumer 'actif' ou 'publie
        return back()->with('success', 'Annonce approuvée.');
    }

    public function reject(Request $request, Annonce $annonce)
    {
        // En phase réelle, on ajouterait une raison de rejet
        $annonce->update(['statut' => 'rejete']);
        return back()->with('success', 'Annonce rejetée.');
    }
}
