<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Resource;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('authentification.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Resource::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Les identifiants fournis sont incorrects.',
            ])->onlyInput('email');
        }

        Auth::login($user);
        $request->session()->regenerate();

        // Informations utilisées par les vues
        Session::put('role', $user->role);
        Session::put('nomuser', $user->nom_prenom);
        Session::put('id', $user->id);
        Session::put('mail', $user->email);

        if ($user->estPatient()) {
            return redirect('/dossier/'.$user->id);
        }

        return redirect()->route('accueil');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
