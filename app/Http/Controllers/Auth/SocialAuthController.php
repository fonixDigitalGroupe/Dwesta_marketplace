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
    public function redirect(Request $request, $provider)
    {
        // Valider que le provider est supporté
        if (!in_array($provider, ['facebook', 'google'])) {
            return redirect()->route('login')->with('error', 'Provider non supporté');
        }

        // Sauvegarder l'intention (login ou register) dans la session
        session(['social_auth_action' => $request->query('action', 'login')]);

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
            $action = session()->pull('social_auth_action', 'login');
            
            \Log::info('Social Login Callback started', ['provider' => $provider, 'action' => $action]);
            
            $socialUser = Socialite::driver($provider)->user();
            
            \Log::info('Social User retrieved', [
                'id' => $socialUser->getId(),
                'email' => $socialUser->getEmail(),
                'name' => $socialUser->getName()
            ]);

            $user = User::where('provider', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();

            if (!$user) {
                \Log::info('Existing user by provider not found. Checking email.');
                
                // Vérifier si l'email existe déjà
                if ($socialUser->getEmail()) {
                    $user = User::where('email', $socialUser->getEmail())->first();
                }

                if (!$user) {
                    // Si on est en mode "login" uniquement, on refuse la création
                    if ($action === 'login') {
                        \Log::info('User not found in login mode. Aborting.');
                        return redirect()->route('login')->with('error', 'Aucun compte trouvé avec cet e-mail. Veuillez d\'abord créer un compte.');
                    }

                    \Log::info('No user found. Creating new user (Register mode).');
                    
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

                    \Log::info('User created successfully. Assigning role.');
                    $user->assignRole('acheteur');
                } else {
                    \Log::info('User found by email. Updating provider info.');
                    
                    // Mettre à jour l'utilisateur existant
                    $updateData = [
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                    ];

                    // Si l'utilisateur n'était pas vérifié, on le considère comme vérifié via le provider social
                    if (!$user->email_verified_at) {
                        $updateData['email_verified_at'] = now();
                    }

                    // Mettre à jour l'avatar si l'utilisateur n'en a pas déjà un
                    if (!$user->avatar && $socialUser->getAvatar()) {
                        $updateData['avatar'] = $socialUser->getAvatar();
                    }

                    $user->update($updateData);
                    \Log::info('User updated successfully (and verified if needed).');
                }
            } else {
                \Log::info('User found by provider and ID.');
            }

            Auth::login($user);
            \Log::info('User logged in successfully.');

            return redirect()->route('home');
        } catch (\Exception $e) {
            // Logger l'erreur détaillée pour le débogage
            \Log::error('Social Login Error: ' . $e->getMessage(), [
                'provider' => $provider,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Erreur lors de la connexion avec ' . $provider;

            // Messages d'erreur plus spécifiques
            if (str_contains($e->getMessage(), 'invalid_client')) {
                $errorMessage = 'Configuration OAuth incorrecte (Client ID ou Secret).';
            } elseif (str_contains($e->getMessage(), 'redirect_uri_mismatch')) {
                $errorMessage = 'URL de redirection incorrecte.';
            }

            return redirect()->route('login')->with('error', $errorMessage);
        }
    }
}




