<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Annonce $annonce)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = Auth::user();
        $isFavorite = $user->favorites()->where('annonce_id', $annonce->id)->exists();

        if ($isFavorite) {
            $user->favorites()->detach($annonce->id);
            $status = 'removed';
            $message = 'Retiré des favoris';
        } else {
            $user->favorites()->attach($annonce->id);
            $status = 'added';
            $message = 'Ajouté aux favoris';
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'count' => $annonce->favoritedBy()->count()
        ]);
    }
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('medias')->latest()->paginate(20);
        return view('favorites.index', compact('favorites'));
    }
}
