<?php

namespace App\Http\Controllers\Partenaire;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SmsOtpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /** Indicatifs pays acceptés (repris du CountryCodePicker mobile). */
    public const PAYS = [
        ['name' => 'Sénégal',          'code' => 'SN', 'phoneCode' => '+221', 'flag' => '🇸🇳', 'digits' => 9],
        ['name' => 'Congo-Brazzaville', 'code' => 'CG', 'phoneCode' => '+242', 'flag' => '🇨🇬', 'digits' => 9],
        ['name' => 'Botswana',          'code' => 'BW', 'phoneCode' => '+267', 'flag' => '🇧🇼', 'digits' => 8],
        ['name' => "Côte d'Ivoire",     'code' => 'CI', 'phoneCode' => '+225', 'flag' => '🇨🇮', 'digits' => 10],
    ];

    /** Écran « Quel est votre numéro ? ». */
    public function showPhone()
    {
        return view('partenaire.auth.phone', ['pays' => self::PAYS]);
    }

    /** Génère et envoie un code OTP au numéro saisi. */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone_code' => ['required', 'string'],
            'phone'      => ['required', 'string', 'min:6', 'max:20'],
        ], [], ['phone' => 'numéro']);

        $phone = $this->normalise($request->phone_code, $request->phone);
        $otp   = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        session(['partenaire_auth' => [
            'phone'      => $phone,
            'otp_code'   => $otp,
            'expires_at' => now()->addMinutes(15),
        ]]);

        Notification::route('mail', $phone)->notify(new SmsOtpNotification($otp));

        // En local, l'API Orange n'est pas joignable : on expose le code pour les tests.
        if (app()->environment('local')) {
            session()->flash('dev_otp', $otp);
        }

        return redirect()->route('partenaire.otp');
    }

    /** Écran de saisie du code à 4 chiffres. */
    public function showOtp()
    {
        $auth = session('partenaire_auth');

        if (! $auth) {
            return redirect()->route('partenaire.login');
        }

        return view('partenaire.auth.otp', ['phone' => $auth['phone']]);
    }

    /** Vérifie le code OTP, connecte (ou crée) l'utilisateur. */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp'   => ['required', 'array', 'size:4'],
            'otp.*' => ['required', 'numeric', 'digits:1'],
        ]);

        $auth = session('partenaire_auth');

        if (! $auth) {
            return redirect()->route('partenaire.login')->with('error', 'Session expirée. Veuillez recommencer.');
        }

        if ($auth['otp_code'] !== implode('', $request->otp)) {
            return back()->withErrors(['otp' => 'Le code de vérification est incorrect.']);
        }

        if ($auth['expires_at'] < now()) {
            return back()->withErrors(['otp' => 'Le code a expiré. Demandez-en un nouveau.']);
        }

        $user = User::firstOrCreate(
            ['telephone' => $auth['phone']],
            [
                'prenom'    => 'Partenaire',
                'nom'       => 'Karnou',
                'password'  => Hash::make(Str::random(24)),
                'is_active' => true,
            ]
        );

        $user->forceFill(['telephone_verified_at' => now()])->save();

        session()->forget('partenaire_auth');
        Auth::login($user, true);
        $request->session()->regenerate();

        // Déjà un profil logistique -> tableau de bord ; sinon -> permissions puis choix du métier.
        if ($user->estLivreur() || $user->estTransporteur()) {
            return redirect()->route('partenaire.home');
        }

        return redirect()->route('partenaire.permissions');
    }

    /** Renvoie un nouveau code. */
    public function resendOtp()
    {
        $auth = session('partenaire_auth');

        if (! $auth) {
            return redirect()->route('partenaire.login');
        }

        $otp = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $auth['otp_code']   = $otp;
        $auth['expires_at'] = now()->addMinutes(15);
        session(['partenaire_auth' => $auth]);

        Notification::route('mail', $auth['phone'])->notify(new SmsOtpNotification($otp));

        if (app()->environment('local')) {
            session()->flash('dev_otp', $otp);
        }

        return back()->with('success', 'Un nouveau code vous a été envoyé.');
    }

    /** Déconnexion partenaire. */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('partenaire.entry');
    }

    /** Normalise un numéro en format E.164 (ex: +221770000000). */
    private function normalise(string $code, string $phone): string
    {
        $code  = '+' . preg_replace('/\D/', '', $code);
        $local = preg_replace('/\D/', '', $phone);

        return $code . ltrim($local, '0');
    }
}
