<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        // Valider que le provider est supporté
        if (!in_array($provider, ['facebook', 'google'])) {
            return redirect()->route('login')->with('error', 'Provider non supporté');
        }

        // Configurer les scopes pour Facebook
        if ($provider === 'facebook') {
            return Socialite::driver($provider)
                ->scopes(['email'])
                ->redirect();
        }

        // Pour Google, les scopes par défaut incluent email et profile
        return Socialite::driver($provider)
            ->scopes(['email', 'profile'])
            ->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::where('provider', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();

            if (!$user) {
                // Vérifier si l'email existe déjà
                if ($socialUser->getEmail()) {
                    $user = User::where('email', $socialUser->getEmail())->first();
                }

                if (!$user) {
                    // Créer un nouvel utilisateur
                    $nameParts = explode(' ', $socialUser->getName() ?? 'Utilisateur', 2);
                    $user = User::create([
                        'prenom' => $nameParts[0] ?? 'Utilisateur',
                        'nom' => $nameParts[1] ?? null,
                        'email' => $socialUser->getEmail(),
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                        'password' => Hash::make(uniqid()),
                        'email_verified_at' => now(),
                        'avatar' => $socialUser->getAvatar(),
                    ]);

                    $user->assignRole('Acheteur');
                } else {
                    // Mettre à jour l'utilisateur existant
                    $updateData = [
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                    ];

                    // Mettre à jour l'avatar si l'utilisateur n'en a pas déjà un
                    if (!$user->avatar && $socialUser->getAvatar()) {
                        $updateData['avatar'] = $socialUser->getAvatar();
                    }

                    $user->update($updateData);
                }
            }

            Auth::login($user);

            return redirect()->route('home');
        } catch (\Exception $e) {
            // Logger l'erreur pour le débogage
            \Log::error('OAuth Error: ' . $e->getMessage(), [
                'provider' => $provider,
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Erreur lors de la connexion avec ' . $provider;

            // Messages d'erreur plus spécifiques
            if (str_contains($e->getMessage(), 'invalid_client')) {
                $errorMessage = 'Configuration OAuth incorrecte. Vérifiez vos clés dans le fichier .env';
            } elseif (str_contains($e->getMessage(), 'redirect_uri_mismatch')) {
                $errorMessage = 'URL de redirection incorrecte. Vérifiez la configuration dans Facebook/Google Developers';
            } elseif (str_contains($e->getMessage(), 'access_denied')) {
                $errorMessage = 'Connexion annulée par l\'utilisateur';
            }

            return redirect()->route('login')->with('error', $errorMessage);
        }
    }
}




