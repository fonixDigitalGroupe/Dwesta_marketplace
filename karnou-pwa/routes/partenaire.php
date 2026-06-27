<?php

use Karnou\Pwa\Http\Controllers\AuthController;
use Karnou\Pwa\Http\Controllers\CourseController;
use Karnou\Pwa\Http\Controllers\DashboardController;
use Karnou\Pwa\Http\Controllers\OnboardingController;
use Karnou\Pwa\Http\Controllers\PartenaireController;
use Karnou\Pwa\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Espace Partenaire — PWA mobile (livreurs & transporteurs)
|--------------------------------------------------------------------------
| Module additif : coexiste avec les dashboards /logistique/* existants.
| Chargé via bootstrap/app.php (groupe middleware « web »).
| Préfixe d'URL : /partenaire — préfixe de nom : partenaire.
*/

Route::prefix('partenaire')->name('partenaire.')->group(function () {
    // Splash / point d'entrée (public, redirige selon l'état de connexion)
    Route::get('/', [PartenaireController::class, 'entry'])->name('entry');

    // Connexion par téléphone + OTP
    Route::get('/connexion', [AuthController::class, 'showPhone'])->name('login');
    Route::post('/connexion/otp', [AuthController::class, 'sendOtp'])->name('otp.send');
    Route::get('/verification', [AuthController::class, 'showOtp'])->name('otp');
    Route::post('/verification', [AuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/verification/renvoyer', [AuthController::class, 'resendOtp'])->name('otp.resend');

    // Espace authentifié
    Route::middleware('auth')->group(function () {
        Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');

        // Onboarding : autorisations, choix du métier, formulaires KYC
        Route::get('/permissions', [OnboardingController::class, 'permissions'])->name('permissions');
        Route::get('/metier', [OnboardingController::class, 'metier'])->name('metier');
        Route::get('/inscription/livreur', [OnboardingController::class, 'showLivreur'])->name('inscription.livreur');
        Route::post('/inscription/livreur', [OnboardingController::class, 'storeLivreur'])->name('inscription.livreur.store');
        Route::get('/inscription/transporteur', [OnboardingController::class, 'showTransporteur'])->name('inscription.transporteur');
        Route::post('/inscription/transporteur', [OnboardingController::class, 'storeTransporteur'])->name('inscription.transporteur.store');

        // Tableau de bord chauffeur (carte + missions)
        Route::get('/accueil', [DashboardController::class, 'home'])->name('home');
        Route::post('/en-ligne', [DashboardController::class, 'toggleOnline'])->name('toggle-online');
        Route::post('/position', [DashboardController::class, 'updatePosition'])->name('position');
        Route::get('/missions', [DashboardController::class, 'missions'])->name('missions');

        // Profil & gains
        Route::get('/profil', [ProfilController::class, 'profil'])->name('profil');
        Route::get('/gains', [ProfilController::class, 'gains'])->name('gains');

        // Courses : acceptation + cycle de vie
        Route::get('/course/active', [CourseController::class, 'active'])->name('course.active');
        Route::post('/course/{order}/accepter', [CourseController::class, 'accept'])->name('course.accept');
        Route::post('/course/{order}/terminer', [CourseController::class, 'complete'])->name('course.complete');
    });
});
