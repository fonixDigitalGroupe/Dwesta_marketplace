<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\EmailOtpNotification;

class OtpController extends Controller
{
    /**
     * Affiche le formulaire de saisie de l'OTP.
     */
    public function showVerifyForm()
    {
        $regInfo = session('reg_info');

        if (!$regInfo) {
            return redirect()->route('register');
        }

        return view('auth.otp-verify', compact('regInfo'));
    }

    /**
     * Vérifie le code OTP soumis.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|min:4|max:4',
            'otp.*' => 'required|numeric|digits:1',
        ]);

        $otpCode = implode('', $request->otp);
        $regInfo = session('reg_info');

        if (!$regInfo) {
            return redirect()->route('register')->with('error', 'Session expirée. Veuillez recommencer.');
        }

        // 1. Vérification si le code correspond
        if ($regInfo['otp_code'] !== $otpCode) {
            return back()->withErrors(['otp' => 'Le code de vérification est incorrect.']);
        }

        // 2. Vérification de l'expiration
        if ($regInfo['otp_expires_at'] < now()) {
            return back()->withErrors(['otp' => 'Le code a expiré. Veuillez en demander un nouveau.']);
        }

        // 3. Création RÉELLE de l'utilisateur
        $user = User::create([
            'prenom'       => 'Utilisateur',
            'nom'          => 'Karnou',
            'email'        => $regInfo['email'],
            'telephone'    => $regInfo['telephone'],
            'password'     => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(12)),
            'is_active'    => true, // Activé par défaut comme demandé par le client
            'email_verified_at' => now(), 
        ]);

        // S'assure que le rôle existe (évite une erreur si non encore seedé en prod)
        \Spatie\Permission\Models\Role::findOrCreate('acheteur', 'web');
        $user->assignRole('acheteur');

        // Nettoyer la session
        session()->forget('reg_info');

        // Connecter l'utilisateur
        Auth::login($user);

        return redirect()->route('register.complete')->with('success', 'Votre compte a été vérifié avec succès ! Veuillez compléter votre profil.');
    }

    /**
     * Renvoie un nouveau code OTP.
     */
    public function resend()
    {
        $regInfo = session('reg_info');

        if (!$regInfo) {
            return redirect()->route('register');
        }

        // Générer un nouveau code
        $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        
        $regInfo['otp_code'] = $otp;
        $regInfo['otp_expires_at'] = now()->addMinutes(15);
        session(['reg_info' => $regInfo]);

        if ($regInfo['email']) {
            \Illuminate\Support\Facades\Notification::route('mail', $regInfo['email'])
                ->notify(new EmailOtpNotification($otp));
        } else {
            \Illuminate\Support\Facades\Notification::route('mail', 'sms-simulation@karnou.com')
                ->notify(new \App\Notifications\SmsOtpNotification($otp));
        }

        return back()->with('success', 'Un nouveau code de vérification vous a été envoyé.');
    }
}
