<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            App\Http\Middleware\LocalizationMiddleware::class,
        ]);

        // Raccourci utilisé dans routes/web.php : ->middleware('acces:patients')
        $middleware->alias([
            'acces' => App\Http\Middleware\VerifierAcces::class,
        ]);

        // Visiteur non connecté : renvoyé vers la page de connexion
        $middleware->redirectGuestsTo(fn () => route('login'));

        // Utilisateur déjà connecté qui ouvre /login : renvoyé vers sa page d'accueil
        $middleware->redirectUsersTo(function (Request $request) {
            $user = $request->user();

            return $user && $user->estPatient()
                ? '/dossier/'.$user->id
                : route('accueil');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Suppression d'un élément encore utilisé ailleurs (ex. une catégorie qui a des médicaments) :
        // au lieu d'une page d'erreur, on revient à la page précédente avec un message clair.
        $exceptions->render(function (QueryException $e, Request $request) {
            if ($e->getCode() === '23000' && $request->is('delete-*')) {
                return redirect()->back()->with('status', 'Suppression impossible : cet élément est encore utilisé ailleurs dans l\'application.');
            }
        });
    })->create();
