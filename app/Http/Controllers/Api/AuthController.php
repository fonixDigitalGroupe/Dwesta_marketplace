<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Inscription (retourne un token Sanctum).
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'prenom'    => ['required', 'string', 'max:255'],
            'nom'       => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email'],
            'telephone' => ['nullable', 'string', 'max:25', 'unique:users,telephone'],
            'password'  => ['required', 'string', 'min:6'],
        ]);

        $user = User::create([
            'prenom'    => $data['prenom'],
            'nom'       => $data['nom'],
            'email'     => $data['email'],
            'telephone' => $data['telephone'] ?? null,
            'password'  => Hash::make($data['password']),
        ]);

        // Attribution du rôle acheteur (sans planter si le rôle n'existe pas encore)
        try {
            \Spatie\Permission\Models\Role::findOrCreate('acheteur', 'web');
            $user->assignRole('acheteur');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('API register: rôle acheteur non attribué', ['error' => $e->getMessage()]);
        }

        return response()->json([
            'token' => $user->createToken('mobile')->plainTextToken,
            'user'  => $this->userPayload($user),
        ], 201);
    }

    /**
     * Connexion par email OU téléphone + mot de passe.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'login'    => ['required', 'string'], // email ou téléphone
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['login'])
            ->orWhere('telephone', $data['login'])
            ->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['Identifiants invalides.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken('mobile')->plainTextToken,
            'user'  => $this->userPayload($user),
        ]);
    }

    /**
     * Profil de l'utilisateur connecté.
     */
    public function me(Request $request)
    {
        return response()->json(['user' => $this->userPayload($request->user())]);
    }

    /**
     * Déconnexion (révoque le token courant).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnecté.']);
    }

    private function userPayload(User $user): array
    {
        return [
            'id'             => $user->id,
            'prenom'         => $user->prenom,
            'nom'            => $user->nom,
            'email'          => $user->email,
            'telephone'      => $user->telephone,
            'avatar'         => $user->avatar ? asset('storage/' . $user->avatar) : null,
            'est_vendeur'    => $user->estVendeur(),
            'profil_complet' => $user->profilComplet(),
            'champs_manquants' => $user->champsProfilManquants(),
        ];
    }
}
