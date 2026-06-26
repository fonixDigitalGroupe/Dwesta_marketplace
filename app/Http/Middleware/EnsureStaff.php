<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStaff
{
    /**
     * Autorise l'accès au back-office (admin) aux utilisateurs « staff » :
     * rôle admin ou rôle personnalisé (ni client, ni vendeur, ni logistique).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->isStaff()) {
            abort(403);
        }

        return $next($request);
    }
}
