<?php

namespace Karnou\Pwa;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Module PWA Partenaire (livreurs & transporteurs).
 *
 * Enregistre les routes et les vues du module, qui vit dans le dossier
 * karnou-pwa/ à la racine du projet (hors de app/ et resources/).
 *
 * - Routes  : karnou-pwa/routes/partenaire.php (groupe middleware « web »)
 * - Vues    : karnou-pwa/resources/views, namespace « partenaire »
 *             -> référencées via view('partenaire::home'), @extends('partenaire::layouts.partenaire')
 *
 * Note : les assets statiques de la PWA (manifest, icônes, service worker)
 * restent dans public/ (public/pwa et public/sw.js) car ils doivent être
 * servis depuis la racine web du navigateur.
 */
class KarnouPwaServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::middleware('web')->group(__DIR__ . '/../routes/partenaire.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'partenaire');
    }
}
