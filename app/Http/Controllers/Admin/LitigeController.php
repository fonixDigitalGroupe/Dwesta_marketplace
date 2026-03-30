<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Litige;
use Illuminate\Http\Request;

class LitigeController extends Controller
{
    public function index()
    {
        $litiges = Litige::with(['reporter', 'reported'])->latest()->paginate(8);
        return view('admin.litiges.index', compact('litiges'));
    }

    public function show(Litige $litige)
    {
        $litige->load(['reporter', 'reported', 'order.items.annonce']);
        return view('admin.litiges.show', compact('litige'));
    }

    public function resolve(Request $request, Litige $litige)
    {
        $request->validate([
            'resolution' => 'required|string',
            'statut' => 'required|in:resolu,ferme',
        ]);

        $litige->update([
            'resolution' => $request->input('resolution'),
            'statut' => $request->input('statut'),
        ]);

        return redirect()->route('admin.litiges.show', $litige)->with('success', 'Litige mis à jour.');
    }
}
