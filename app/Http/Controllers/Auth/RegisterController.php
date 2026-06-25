<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Notifications\EmailOtpNotification;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $countries = \App\Models\Country::active()->orderBy('name')->get();
        return view('auth.register', compact('countries'));
    }

    public function register(Request $request)
    {
        $phoneMode = $request->filled('reg_login_phone');
        
        // Validation simplifiée pour l'étape 1
        $rules = [];
        if ($phoneMode) {
            $rules['reg_login_phone'] = ['required', 'string', 'max:25', 'unique:users,telephone'];
        } else {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
        }

        $request->validate($rules, [
            'email.unique' => 'Cet email est déjà utilisé.',
            'reg_login_phone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        ]);

        $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        // Au lieu de créer le compte, on stocke les infos en session
        session(['reg_info' => [
            'email'     => $phoneMode ? null : $request->email,
            'telephone' => $phoneMode ? $request->reg_login_phone : null,
            'otp_code'  => $otp,
            'otp_expires_at' => now()->addMinutes(15),
        ]]);

        // Envoi de l'OTP sans créer d'utilisateur DB
        if (!$phoneMode) {
            \Illuminate\Support\Facades\Notification::route('mail', $request->email)
                ->notify(new EmailOtpNotification($otp));
        } else {
            \Illuminate\Support\Facades\Notification::route('mail', 'sms-simulation@karnou.com') // Simulation dev
                ->notify(new \App\Notifications\SmsOtpNotification($otp));
        }

        return redirect()->route('otp.verify');
    }

    public function showCompletionForm()
    {
        $user = Auth::user();
        // Le compte est actif dès la vérification OTP (is_active = true) ; on ne peut
        // donc pas s'y fier pour savoir si le profil est complété. La civilité n'est
        // renseignée qu'à la complétion → si elle existe, le profil est déjà fait.
        if ($user->civilite) {
            return redirect()->route('account.index');
        }

        $countries = \App\Models\Country::active()->orderBy('name')->get();
        return view('auth.register-complete', compact('countries', 'user'));
    }

    public function completeRegistration(Request $request)
    {
        $request->validate([
            'civilite' => ['required', 'string', 'in:madame,monsieur'],
            'prenom'   => ['required', 'string', 'max:255'],
            'nom'      => ['required', 'string', 'max:255'],
            'nationalite' => ['required', 'string', 'max:100'],
            'adresse'  => ['required', 'string', 'max:500'],
            'birth_day'   => ['required', 'numeric', 'between:1,31'],
            'birth_month' => ['required', 'numeric', 'between:1,12'],
            'birth_year'  => ['required', 'numeric', 'between:1900,' . date('Y')],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(6)],
            'terms'    => ['accepted'],
        ], [
            'civilite.required' => 'Veuillez sélectionner votre civilité.',
            'terms.accepted' => 'Vous devez accepter les conditions d\'utilisation.',
            'password.min' => 'Le mot de passe doit faire au moins 6 caractères.',
        ]);

        $date_de_naissance = $request->birth_year . '-' . 
                            str_pad($request->birth_month, 2, '0', STR_PAD_LEFT) . '-' . 
                            str_pad($request->birth_day, 2, '0', STR_PAD_LEFT);

        $user = Auth::user();
        $user->update([
            'civilite'     => $request->civilite,
            'prenom'       => $request->prenom,
            'nom'          => $request->nom,
            'date_de_naissance' => $date_de_naissance,
            'nationalite'  => $request->nationalite,
            'adresse'      => $request->adresse,
            'password'     => Hash::make($request->password),
            'is_active'    => true,
            'email_verified_at' => $user->email_verified_at ?? now(),
        ]);

        // Message de bienvenue Karnou dans la boîte de messagerie
        $this->sendKarnouWelcomeMessage($user);

        return redirect()->route('account.index')->with('success', 'Votre profil a été complété avec succès ! Bienvenue chez Karnou.');
    }

    /**
     * Envoie un message de bienvenue officiel de « Karnou » dans la messagerie
     * du nouvel utilisateur. Tolérant aux pannes : n'interrompt jamais l'inscription.
     */
    private function sendKarnouWelcomeMessage(User $user): void
    {
        try {
            // Expéditeur officiel : le compte admin Karnou (sinon, premier admin).
            $karnou = User::where('email', 'admin@karnou.com')->first()
                ?? User::role('admin')->first();

            if (!$karnou || $karnou->id === $user->id) {
                return;
            }

            // Conversation existante (bidirectionnelle) ou nouvelle.
            $conversation = \App\Models\Conversation::where(function ($q) use ($karnou, $user) {
                $q->where('user1_id', $karnou->id)->where('user2_id', $user->id);
            })->orWhere(function ($q) use ($karnou, $user) {
                $q->where('user1_id', $user->id)->where('user2_id', $karnou->id);
            })->first();

            if (!$conversation) {
                $conversation = \App\Models\Conversation::create([
                    'user1_id'        => $karnou->id,
                    'user2_id'        => $user->id,
                    'last_message_at' => now(),
                ]);
            }

            // Évite les doublons si la méthode est rejouée.
            if ($conversation->messages()->where('sender_id', $karnou->id)->exists()) {
                return;
            }

            $prenom = $user->prenom ?: 'cher utilisateur';
            $content = "Bienvenue sur Karnou, {$prenom} ! 🎉 Nous sommes ravis de vous compter parmi nous.\n\n"
                . "Complétez votre profil ! Afin de profiter pleinement de Karnou, veuillez renseigner votre adresse et votre position géographique.\n\n"
                . "👉 [Compléter mon profil](/profile)";

            $conversation->messages()->create([
                'sender_id' => $karnou->id,
                'content'   => $content,
                'read_at'   => null,
            ]);

            $conversation->update(['last_message_at' => now()]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Karnou welcome message error: ' . $e->getMessage());
        }
    }

    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }
}


