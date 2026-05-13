<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Livreur;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerification;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Step 1: Store contact and redirect to OTP
     */
    public function storeStep1(Request $request): RedirectResponse
    {
        $request->validate([
            'contact' => ['required', 'string', 'max:255'],
        ]);

        $contact = $request->contact;
        $isEmail = filter_var($contact, FILTER_VALIDATE_EMAIL);

        // Generate OTP
        $otp = (string) rand(1000, 9999);
        
        session([
            'register_contact' => $contact,
            'register_is_email' => $isEmail,
            'register_otp' => $otp
        ]);

        // Send OTP via Email if contact is email
        if ($isEmail) {
            Mail::to($contact)->send(new OtpVerification($otp));
        }
        // If phone, we would send SMS (mocked for now as we don't have SMS provider)

        return redirect()->route('register.otp.view');
    }

    /**
     * Show OTP verification view
     */
    public function showOtpVerification(): View
    {
        if (!session('register_contact')) {
            return redirect()->route('register');
        }

        return view('auth.verify-otp', [
            'contact' => session('register_contact')
        ]);
    }

    /**
     * Step 2: Verify OTP and complete registration
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:4'],
        ]);

        if ($request->otp !== session('register_otp')) {
            throw ValidationException::withMessages([
                'otp' => ['Le code OTP est incorrect.'],
            ]);
        }

        $contact = session('register_contact');
        $isEmail = session('register_is_email');

        // Check if user already exists
        $user = User::where($isEmail ? 'email' : 'telephone', $contact)->first();

        if (!$user) {
            // Create New User
            $user = User::create([
                'prenom' => 'Livreur_' . Str::random(5),
                'email' => $isEmail ? $contact : 'livreur_' . time() . '@karnou.com',
                'telephone' => !$isEmail ? $contact : null,
                'password' => Hash::make(Str::random(12)),
            ]);
            
            // Assign role (assuming Role model or simple logic)
            // For now we create the Livreur profile directly
        }

        // Create Livreur profile if not exists
        if (!$user->livreur) {
            Livreur::create([
                'user_id' => $user->id,
                'statut_verification' => 'en_attente',
                'matricule' => 'LIV-' . strtoupper(Str::random(6)), // Matricule logic
                'actif' => true,
            ]);
        }

        $user->email_verified_at = now();
        $user->telephone_verified_at = now();
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        // Clear session
        session()->forget(['register_contact', 'register_is_email', 'register_otp']);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Original Breeze store method (Redirected to step 1)
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->storeStep1($request);
    }
}
