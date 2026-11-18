<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Resource;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('authentification.login');  
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = Resource::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            Session::put('role', $user->role);
            Session::put('nomuser', $user->nom_prenom);
            Session::put('id', $user->id);
            Session::put('mail', $user->email);
            $idpatatient = session('id');
            if(session('role') == 'patient'){
                return redirect('/dossier/'. $user->id);
            }else{
                return redirect()->route('accueil');
            }
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis sont incorrects.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}