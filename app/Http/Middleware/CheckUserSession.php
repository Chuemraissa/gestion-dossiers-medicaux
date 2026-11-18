<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserSession
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est connecté
        if (!session()->has('id')) {
            // Redirige l'utilisateur vers la page de connexion
            return redirect('/login');
        }

        return $next($request);
    }
}