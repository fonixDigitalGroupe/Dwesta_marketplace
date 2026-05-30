<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\PointRelais;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $agence = $user->pointRelais()->first();
        
        $search = $request->query('search');
        $perPage = $request->query('per_page', 8);

        $usersQuery = $agence ? $agence->users() : \App\Models\User::whereRaw('1=0');

        if ($search) {
            $usersQuery->where(function($q) use ($search) {
                $q->where('prenom', 'like', "%{$search}%")
                  ->orWhere('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return view('profile.edit', [
            'user'    => $user,
            'agence'  => $agence,
            'users'   => $usersQuery->paginate($perPage)->withQueryString(),
            'search'  => $search,
            'perPage' => $perPage,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the current agency (PointRelais) configuration.
     */
    public function updateAgence(Request $request): RedirectResponse
    {
        $agence = Auth::user()->pointRelais()->first();

        if (!$agence) {
            return Redirect::route('profile.edit', ['tab' => 'configuration'])
                ->with('error', 'Aucune agence associée à ce compte.');
        }

        $validated = $request->validate([
            'nom'             => 'required|string|max:255',
            'email'           => 'nullable|email|max:255',
            'adresse'         => 'required|string',
            'pays'            => 'required|string|max:100',
            'region'          => 'nullable|string|max:100',
            'latitude'        => 'nullable|numeric|between:-90,90',
            'longitude'       => 'nullable|numeric|between:-180,180',
            'google_maps_url' => 'nullable|url',
            'telephone'       => 'nullable|string|max:20',
        ]);

        $agence->update($validated);

        return Redirect::route('profile.edit', ['tab' => 'configuration'])
            ->with('status', 'agence-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Store a new user for the current agency.
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $agence = Auth::user()->pointRelais()->first();

        if (!$agence) {
            return Redirect::route('profile.edit', ['tab' => 'utilisateur'])
                ->with('error', 'Aucune agence associée à ce compte.');
        }

        $validated = $request->validate([
            'prenom'   => 'required|string|max:255',
            'nom'      => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = \App\Models\User::create([
            'prenom'   => $validated['prenom'],
            'nom'      => $validated['nom'],
            'email'    => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        $agence->users()->attach($user->id);

        return Redirect::route('profile.edit', ['tab' => 'utilisateur'])->with('status', 'user-added');
    }

    /**
     * Update an agency user.
     */
    public function updateUser(Request $request, \App\Models\User $user): RedirectResponse
    {
        $validated = $request->validate([
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
        ]);

        $user->update([
            'name' => $validated['prenom'] . ' ' . $validated['nom'],
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
        ]);

        return Redirect::route('profile.edit', ['tab' => 'utilisateur'])->with('status', 'user-updated');
    }

    /**
     * Remove an agency user.
     */
    public function destroyUser(Request $request, \App\Models\User $user): RedirectResponse
    {
        $currentUser = $request->user();
        $agence = $currentUser->pointRelais()->first();

        if ($agence && $user->id !== $currentUser->id) {
            $agence->users()->detach($user->id);
            // Optionally delete the user if they were specifically created for the agency
            $user->delete();
        }

        return Redirect::route('profile.edit', ['tab' => 'utilisateur'])->with('status', 'user-deleted');
    }
}
