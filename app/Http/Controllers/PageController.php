<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Affiche la page "À propos de Karnou".
     */
    public function about()
    {
        $countries = \App\Models\Country::where('is_active', true)->get();
        return view('pages.about', compact('countries'));
    }

    /**
     * Affiche la page "Conditions Générales d'Utilisation".
     */
    public function terms()
    {
        return view('pages.terms');
    }

    /**
     * Affiche la page "Vie Privée".
     */
    public function privacy()
    {
        return view('pages.privacy');
    }

    /**
     * Affiche la page "Gestion des Cookies".
     */
    public function cookies()
    {
        return view('pages.cookies');
    }
}

