<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use App\Models\Country;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $countries = Country::active()->get();
        return view('auth.login', compact('countries'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'], // email ou téléphone
            'password' => ['required', 'string'],
        ]);

        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';

        if (Auth::attempt([$loginField => $request->login, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->hasRole('transporteur')) {
                return redirect()->intended(route('transporteur.dashboard'));
            } elseif ($user->hasRole('livreur')) {
                return redirect()->intended(route('livreur.dashboard'));
            } elseif ($user->hasRole('point_relais')) {
                return redirect()->intended(route('relais.dashboard'));
            } elseif ($user->isStaff()) {
                // Admin ou rôle personnalisé (back-office)
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('account.index'));
        }

        throw ValidationException::withMessages([
            'login' => __('Les identifiants fournis sont incorrects.'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}




