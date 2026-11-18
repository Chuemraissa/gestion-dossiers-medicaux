<?php

namespace App\Http\Controllers;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

abstract class Controller
{
    /**
     * Envoie un e-mail sans bloquer l'application si le serveur de mail ne répond pas.
     * En cas d'échec, l'erreur est notée dans storage/logs/laravel.log et la page continue.
     */
    protected function envoyerMail(?string $destinataire, Mailable $mail): bool
    {
        if (empty($destinataire)) {
            return false;
        }

        try {
            Mail::to($destinataire)->send($mail);

            return true;
        } catch (\Throwable $e) {
            Log::warning("E-mail non envoyé à {$destinataire} : ".$e->getMessage());

            return false;
        }
    }

    /**
     * Vrai si l'utilisateur connecté possède l'accès demandé (voir table role_acces).
     */
    protected function aAcces(string $acces): bool
    {
        return (bool) auth()->user()?->aAcces($acces);
    }
}
