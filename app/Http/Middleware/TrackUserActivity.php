<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackUserActivity
{
    /**
     * Marque l'utilisateur connecté comme « en ligne » à chaque requête.
     * La présence expire automatiquement après quelques minutes d'inactivité.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Ne jamais faire échouer la requête si le cache/DB est indisponible
            // (ex. base en lecture seule / droits MySQL manquants).
            try {
                $key = 'user-online-' . Auth::id();
                // Présence valable 3 minutes ; renouvelée à chaque requête.
                Cache::put($key, now()->timestamp, now()->addMinutes(3));
            } catch (\Throwable $e) {
                // silencieux
            }
        }

        return $next($request);
    }
}
