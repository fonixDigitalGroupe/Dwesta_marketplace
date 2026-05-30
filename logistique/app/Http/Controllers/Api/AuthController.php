<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Livreur;
use App\Models\Transporteur;
use App\Notifications\OtpSmsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    /**
     * Envoyer un code OTP par "SMS" (Telescope capturera la notification)
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $phone = $request->phone;
        $otp = (string) rand(1000, 9999);

        // On stocke ou on associe l'OTP à l'utilisateur
        $user = User::firstOrCreate(
            ['telephone' => $phone],
            [
                'prenom' => 'Livreur', 
                'email' => "sms_" . str_replace('+', '', $phone) . "@karnou.com", 
                'password' => bcrypt('password')
            ]
        );

        // Sauvegarde de l'OTP
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10)
        ]);

        $user->notify(new OtpSmsNotification($otp));

        return response()->json([
            'success' => true,
            'message' => 'OTP envoyé avec succès',
            'debug_otp' => $otp // Pour le test
        ]);
    }

    /**
     * Vérifier le code OTP envoyé par le mobile
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string|size:4',
        ]);

        $user = User::where('telephone', $request->phone)
            ->where('otp_code', $request->otp)
            ->where('otp_expires_at', '>', now())
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Code OTP invalide ou expiré.'
            ], 422);
        }

        // OTP valide -> On marque le téléphone comme vérifié (optionnel selon la logique métier)
        // $user->update(['telephone_verified_at' => now(), 'otp_code' => null]);

        // Génération d'un token Sanctum pour la session mobile
        $token = $user->createToken('mobile_auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Authentification réussie',
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Finaliser le profil (Livreur ou Transporteur)
     */
    public function completeProfile(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'user_type' => 'required|in:livreur,transporteur',
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'dob' => 'nullable|string', // Date de naissance
        ]);

        try {
            $dob = null;
            if ($request->dob) {
                try {
                    $dob = \Carbon\Carbon::createFromFormat('d/m/Y', $request->dob);
                } catch (\Exception $e) {
                    // Fallback si le format est différent ou invalide
                    $dob = \Carbon\Carbon::parse($request->dob);
                }
            }

            // Mise à jour de l'utilisateur de base
            $user->update([
                'prenom' => $request->prenom,
                'nom' => $request->nom,
                'email' => $request->email,
                'date_de_naissance' => $dob,
            ]);
        } catch (\Exception $e) {
            \Log::error('Profile Update Error (User): ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour des informations personnelles : ' . $e->getMessage()
            ], 500);
        }

        if ($request->user_type === 'livreur') {
            $request->validate([
                'vehicle_type' => 'required|string',
                'doc_type' => 'required|string',
                'doc_number' => 'required|string',
            ]);

            Livreur::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'type_vehicule' => $request->vehicle_type,
                    'type_document' => $request->doc_type,
                    'numero_document' => $request->doc_number,
                    'statut_verification' => 'en_attente',
                ]
            );
        } else {
            $request->validate([
                'vehicle_type' => 'required|string',
                'transport_type' => 'required|string', // urbain, inter, international
                'itineraire' => 'nullable|string',
            ]);

            Transporteur::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'type_vehicule' => $request->vehicle_type,
                    'statut_verification' => 'en_attente',
                    'marque_vehicule' => $request->itineraire, // On utilise marque pour l'itinéraire temporairement
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil finalisé avec succès',
            'user' => $user->load(['livreur', 'transporteur'])
        ]);
    }
}
