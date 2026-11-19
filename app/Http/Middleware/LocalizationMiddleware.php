<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Langue choisie par l'utilisateur, sinon la langue par défaut du .env (APP_LOCALE)
        $locale = Session::get('locale');

        // Langue inconnue (dossier absent dans lang/) : on revient à la langue par défaut
        if (! $locale || ! is_dir(lang_path($locale))) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
