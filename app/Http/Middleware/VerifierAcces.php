<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifierAcces
{
    /**
     * Laisse passer la requête seulement si le rôle de l'utilisateur connecté
     * possède au moins un des accès demandés (table role_acces).
     *
     * Exemple dans les routes : ->middleware('acces:patients')
     */
    public function handle(Request $request, Closure $next, string ...$acces)
    {
        if ($request->user()?->aAcces(...$acces)) {
            return $next($request);
        }

        abort(403, "Vous n'avez pas accès à cette page.");
    }
}
