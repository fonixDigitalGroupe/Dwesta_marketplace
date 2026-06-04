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
        $user = Auth::user();

        // Si l'utilisateur est déjà vérifié, rediriger vers le profil
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('profile.show');
        }

        return view('auth.otp-verify');
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
        $user = Auth::user();

        // 1. Vérification si le code correspond
        if ($user->otp_code !== $otpCode) {
            return back()->withErrors(['otp' => 'Le code de vérification est incorrect.']);
        }

        // 2. Vérification de l'expiration (15 minutes)
        if ($user->otp_expires_at < now()) {
            return back()->withErrors(['otp' => 'Le code a expiré. Veuillez en demander un nouveau.']);
        }

        // 3. Marquer comme vérifié
        $user->markEmailAsVerified();
        
        // Nettoyer l'OTP
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        return redirect()->route('register.complete')->with('success', 'Votre compte a été vérifié avec succès ! Veuillez compléter votre profil.');
    }

    /**
     * Renvoie un nouveau code OTP.
     */
    public function resend()
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('profile.show');
        }

        // Générer un nouveau code
        $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(15),
        ]);

        $user->notify(new EmailOtpNotification($otp));

        return back()->with('success', 'Un nouveau code de vérification vous a été envoyé.');
    }
}
