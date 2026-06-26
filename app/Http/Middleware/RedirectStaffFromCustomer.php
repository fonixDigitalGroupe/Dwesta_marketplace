<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectStaffFromCustomer
{
    /**
     * L'espace client (/mon-compte, etc.) est réservé aux vendeurs et clients.
     * Un utilisateur « staff » (admin ou rôle personnalisé) est redirigé vers le back-office.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // On ne redirige pas si on est déjà dans le back-office (évite une boucle,
        // car les routes admin sont imbriquées dans le même groupe).
        if ($user && $user->isStaff() && !$request->is('admin', 'admin/*')) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
