<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * « Mot de passe oublié » : l'utilisateur reçoit par e-mail un lien
 * pour choisir un nouveau mot de passe (lien valable 60 minutes).
 */
class MotDePasseController extends Controller
{
    public function formulaireDemande()
    {
        return view('authentification.mot-de-passe-oublie');
    }

    public function envoyerLien(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $statut = Password::sendResetLink($request->only('email'));

        // Même message que l'adresse existe ou non : on ne révèle pas quels comptes existent
        if ($statut === Password::RESET_THROTTLED) {
            return back()->withErrors(['email' => __($statut)])->onlyInput('email');
        }

        return back()->with('status', __(Password::RESET_LINK_SENT));
    }

    public function formulaireReinitialisation(Request $request, string $token)
    {
        return view('authentification.reinitialiser-mot-de-passe', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function reinitialiser(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $statut = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Resource $utilisateur, string $motDePasse) {
                // Le modèle chiffre lui-même le mot de passe (setPasswordAttribute)
                $utilisateur->password = $motDePasse;
                $utilisateur->setRememberToken(Str::random(60));
                $utilisateur->save();

                event(new PasswordReset($utilisateur));
            }
        );

        if ($statut === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($statut));
        }

        return back()->withErrors(['email' => __($statut)])->onlyInput('email');
    }
}
