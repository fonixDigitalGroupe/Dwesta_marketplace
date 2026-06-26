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

            // Messages non lus du compte Karnou (la messagerie admin agit en son nom)
            $karnou = \App\Models\User::where('email', 'admin@karnou.com')->first()
                ?? \App\Models\User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))->first();

            $adminUnreadMessages = 0;
            if ($karnou) {
                $adminUnreadMessages = \App\Models\Message::whereNull('read_at')
                    ->where('sender_id', '!=', $karnou->id)
                    ->whereHas('conversation', function ($q) use ($karnou) {
                        $q->where('user1_id', $karnou->id)->orWhere('user2_id', $karnou->id);
                    })->count();
            }

            $view->with('pendingVendorsCount', $pendingVendorsCount)
                 ->with('adminUnreadMessages', $adminUnreadMessages);
        });
    }
}
