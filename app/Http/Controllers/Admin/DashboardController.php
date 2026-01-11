<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Annonce;
use App\Models\Litige;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users_count' => User::count(),
            'annonces_count' => Annonce::count(),
            'annonces_pending' => Annonce::where('statut', 'en_attente')->count(), // Assumer 'en_attente' exist
            'litiges_open' => Litige::where('statut', 'en_cours')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
