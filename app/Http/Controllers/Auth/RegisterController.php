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

        return redirect()->route('account.index')->with('success', 'Votre profil a été complété avec succès ! Bienvenue chez Karnou.');
    }

    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }
}


