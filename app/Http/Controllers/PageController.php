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

    /**
     * Affiche la page "Besoin d'aide ?".
     */
    public function help()
    {
        return view('pages.help');
    }

    /**
     * Affiche la page "Signaler un contenu".
     */
    public function report()
    {
        return view('pages.report');
    }

    /**
     * Affiche la page "Contact".
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Affiche la page landing "Ouvrir un e-shop".
     */
    public function eshop()
    {
        return view('pages.eshop');
    }
}

