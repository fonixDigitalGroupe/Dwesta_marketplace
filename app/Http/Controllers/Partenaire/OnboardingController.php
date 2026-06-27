<?php

namespace App\Http\Controllers\Partenaire;

use App\Http\Controllers\Controller;
use App\Models\Livreur;
use App\Models\Transporteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class OnboardingController extends Controller
{
    /** Écran d'autorisations (géoloc + notifications) — gérées côté navigateur. */
    public function permissions()
    {
        if ($this->dejaPartenaire()) {
            return redirect()->route('partenaire.home');
        }

        return view('partenaire.permissions');
    }

    /** Choix du métier : livreur ou transporteur. */
    public function metier()
    {
        if ($this->dejaPartenaire()) {
            return redirect()->route('partenaire.home');
        }

        return view('partenaire.metier');
    }

    /* ---------------------------------------------------------------- Livreur */

    public function showLivreur()
    {
        if ($this->dejaPartenaire()) {
            return redirect()->route('partenaire.home');
        }

        return view('partenaire.inscription.livreur', ['user' => Auth::user()]);
    }

    public function storeLivreur(Request $request)
    {
        $data = $request->validate([
            'prenom'        => ['required', 'string', 'max:100'],
            'nom'           => ['required', 'string', 'max:100'],
            'email'         => ['nullable', 'email', 'max:150'],
            'date_de_naissance' => ['nullable', 'date'],
            'type_vehicule' => ['required', 'in:moto,voiture,velo'],
            'type_document' => ['required', 'in:cni,passport,sejour'],
            'numero_document' => ['nullable', 'string', 'max:60'],
            'document_recto' => ['nullable', 'image', 'max:5120'],
            'document_verso' => ['nullable', 'image', 'max:5120'],
        ]);

        $user = Auth::user();

        if ($user->estLivreur() || $user->estTransporteur()) {
            return redirect()->route('partenaire.home');
        }

        $this->majIdentite($user, $data);

        Livreur::create([
            'user_id'             => $user->id,
            'type_vehicule'       => $data['type_vehicule'],
            'type_document'       => $data['type_document'],
            'numero_document'     => $data['numero_document'] ?? null,
            'document_recto'      => $this->upload($request, 'document_recto', 'livreurs'),
            'document_verso'      => $this->upload($request, 'document_verso', 'livreurs'),
            'statut_verification' => 'en_attente',
            'actif'               => true,
        ]);

        Role::findOrCreate('livreur', 'web');
        $user->assignRole('livreur');

        return redirect()->route('partenaire.home')
            ->with('flash', 'Profil livreur envoyé ! Il est en cours de vérification.');
    }

    /* ----------------------------------------------------------- Transporteur */

    public function showTransporteur()
    {
        if ($this->dejaPartenaire()) {
            return redirect()->route('partenaire.home');
        }

        return view('partenaire.inscription.transporteur', ['user' => Auth::user()]);
    }

    public function storeTransporteur(Request $request)
    {
        $data = $request->validate([
            'prenom'          => ['required', 'string', 'max:100'],
            'nom'             => ['required', 'string', 'max:100'],
            'email'           => ['nullable', 'email', 'max:150'],
            'type_vehicule'   => ['required', 'in:camion,van,voiture,moto'],
            'marque_vehicule' => ['nullable', 'string', 'max:80'],
            'modele_vehicule' => ['nullable', 'string', 'max:80'],
            'immatriculation' => ['nullable', 'string', 'max:30'],
            'numero_permis'   => ['nullable', 'string', 'max:60'],
            'numero_cni'      => ['nullable', 'string', 'max:60'],
            'permis_recto'    => ['nullable', 'image', 'max:5120'],
            'carte_grise'     => ['nullable', 'image', 'max:5120'],
        ]);

        $user = Auth::user();

        if ($user->estLivreur() || $user->estTransporteur()) {
            return redirect()->route('partenaire.home');
        }

        $this->majIdentite($user, $data);

        Transporteur::create([
            'user_id'             => $user->id,
            'type_vehicule'       => $data['type_vehicule'],
            'marque_vehicule'     => $data['marque_vehicule'] ?? null,
            'modele_vehicule'     => $data['modele_vehicule'] ?? null,
            'immatriculation'     => $data['immatriculation'] ?? null,
            'numero_permis'       => $data['numero_permis'] ?? null,
            'numero_cni'          => $data['numero_cni'] ?? null,
            'permis_recto'        => $this->upload($request, 'permis_recto', 'transporteurs'),
            'carte_grise'         => $this->upload($request, 'carte_grise', 'transporteurs'),
            'statut_verification' => 'en_attente',
            'actif'               => true,
        ]);

        Role::findOrCreate('transporteur', 'web');
        $user->assignRole('transporteur');

        return redirect()->route('partenaire.home')
            ->with('flash', 'Profil transporteur envoyé ! Il est en cours de vérification.');
    }

    /* ------------------------------------------------------------------ Utils */

    private function dejaPartenaire(): bool
    {
        $user = Auth::user();

        return $user && ($user->estLivreur() || $user->estTransporteur());
    }

    private function majIdentite($user, array $data): void
    {
        $user->fill([
            'prenom'            => $data['prenom'],
            'nom'               => $data['nom'],
            'email'             => $data['email'] ?? $user->email,
            'date_de_naissance' => $data['date_de_naissance'] ?? $user->date_de_naissance,
        ])->save();
    }

    private function upload(Request $request, string $field, string $dossier): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        return $request->file($field)->store("partenaire/{$dossier}", 'public');
    }
}
