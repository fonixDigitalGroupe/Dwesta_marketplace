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
            $pendingLivreursCount = \App\Models\Livreur::where('statut_verification', 'en_attente')->count();
            $pendingTransporteursCount = \App\Models\Transporteur::where('statut_verification', 'en_attente')->count();
            // Commandes ni annulées ni livrées (en cours de traitement)
            $activeOrdersCount = \App\Models\Order::whereNotIn('statut', ['annule', 'livre'])->count();

            // Modération : avis en attente + annonces signalées non traitées
            $pendingModerationCount = \App\Models\Avis::where('statut', 'en_attente')->count()
                + \App\Models\Signalement::where('statut', 'nouveau')->count();

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
                 ->with('pendingLivreursCount', $pendingLivreursCount)
                 ->with('pendingTransporteursCount', $pendingTransporteursCount)
                 ->with('activeOrdersCount', $activeOrdersCount)
                 ->with('pendingModerationCount', $pendingModerationCount)
                 ->with('adminUnreadMessages', $adminUnreadMessages);
        });
    }
}
