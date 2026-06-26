<?php

namespace App\Providers;

use App\Models\Avis;
use App\Models\Vendeur;
use App\Policies\AvisPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Avis::class => AvisPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Le rôle « admin » a toutes les permissions (bypass des @can / can()).
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        View::composer('layouts.admin', function ($view) {
            $pendingVendorsCount = Vendeur::where('statut_verification', 'en_attente')->count();
            $view->with('pendingVendorsCount', $pendingVendorsCount);
        });
    }
}
