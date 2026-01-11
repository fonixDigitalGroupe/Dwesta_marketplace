<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'reviewable_id' => 'required|integer',
            'reviewable_type' => 'required|string|in:user,product', // simplified map
        ]);

        $typeMap = [
            'user' => User::class,
            'product' => Annonce::class,
        ];

        $reviewableType = $typeMap[$request->input('reviewable_type')] ?? null;

        if (!$reviewableType) {
            abort(400, 'Invalid reviewable type');
        }

        Review::create([
            'reviewer_id' => Auth::id(),
            'reviewable_id' => $request->input('reviewable_id'),
            'reviewable_type' => $reviewableType,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return back()->with('success', 'Avis publié avec succès.');
    }
}
