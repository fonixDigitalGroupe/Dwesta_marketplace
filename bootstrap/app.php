<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        // Le module PWA partenaire (routes + vues) est chargé par
        // Karnou\Pwa\KarnouPwaServiceProvider (voir karnou-pwa/).
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            '/webhook/stripe',
        ]);

        // Suivi de présence : marque l'utilisateur « en ligne » à chaque requête web
        $middleware->web(append: [
            \App\Http\Middleware\TrackUserActivity::class,
        ]);

        // Enregistrer les middlewares de Spatie Laravel Permission
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'staff' => \App\Http\Middleware\EnsureStaff::class,
            'customer' => \App\Http\Middleware\RedirectStaffFromCustomer::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
