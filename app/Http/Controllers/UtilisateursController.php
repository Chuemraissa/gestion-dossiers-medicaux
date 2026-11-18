<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Rendez_vous;
use App\Models\Medicament;
use App\Models\Examen;
use App\Models\Consulter;
use App\Mail\WelcomeMail;
use App\Mail\UpdateMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class UtilisateursController extends Controller
{
    public function acceuil()
    {
        $patientCount = Resource::where('role', 'patient')->count();

        $medecinCount = Resource::where('role', 'medecin')->count();

        $rdvCount = Rendez_vous::count();

        $consulterCount = Consulter::count();

        $medCount = Medicament::count();

        $examenCount = Examen::count();
        
        return view('patients.acceuil', compact('patientCount','medecinCount','rdvCount','consulterCount','medCount','examenCount'));
    }

    public function aide()
    {        
        return view('aide.aide');
    }

    public function listeresources()
    {
        $resources = Resource::all();
        return view('resourceshumaines.listesresources', compact('resources'));
    }

    public function ajout_resources(Request $request)
    {
        $request->validate([
            'nom_prenom' => 'required',
            'date_naissance' => 'required',
            'adresse' => 'required',
            'telephone' => 'required',
            'sexe' => 'required',
            'email' => 'required|email|unique:resources',
            'password' => 'required|confirmed|min:8',
            'role' => 'required',
        ]);

        $resources = new Resource();
        $resources->nom_prenom = $request->nom_prenom;
        $resources->adresse = $request->adresse;
        $resources->date_naissance = $request->date_naissance;
        $resources->telephone = $request->telephone;
        $resources->sexe = $request->sexe;
        $resources->email = $request->email;
        $resources->password = $request->password;
        $resources->role = $request->role;
        $resources->save();

        Session::put('nom', $request->nom_prenom); 
        Session::put('email', $request->email);
        Session::put('password', $request->password);
        // Envoyer la notification d'inscription
        Mail::to($request->email)->send(new WelcomeMail());
        

        // Connecter l'utilisateur après l'enregistrement
        auth()->login($resources);


        // Rediriger vers la bonne route en fonction du rôle de l'utilisateur
        if ($resources->role === 'patient') {
            return redirect()->route('patient')->with('status', 'Le patient a été ajouté avec succès.');
        }
        if ($resources->role === 'infirmiere') {
            return redirect()->route('infirmiere')->with('status', 'L\'infirmiere a été ajouté avec succès.');
        }
        if ($resources->role === 'medecin') {
            return redirect()->route('medecin')->with('status', 'Le medecin a été ajouté avec succès.');
        }
        if ($resources->role === 'charge_acceuil') {
            return redirect()->route('CA')->with('status', 'La charge d\'acceuil a été ajouté avec succès.');
        }
        if ($resources->role === 'laborantin') {
            return redirect()->route('labo')->with('status', 'La charge d\'acceuil a été ajouté avec succès.');
        }
        if ($resources->role === 'pharmacien') {
            return redirect()->route('pharmacien')->with('status', 'Le pharmacien a été ajouté avec succès.');
        }
    }

    public function update_id_resources($id)
    {
        $resources = Resource::find($id);
        return view('resourceshumaines.updateresources', compact('resources'));
    }

    public function update_resources_traitement(Request $request)
    {
        $request->validate([
            'nom_prenom' => 'required',
            'date_naissance' => 'required',
            'adresse' => 'required',
            'telephone' => 'required',
            'sexe' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:8',
            'role' => 'required',
        ]);

        $resources = Resource::find($request->id);
        $resources->nom_prenom = $request->nom_prenom;
        $resources->adresse = $request->adresse;
        $resources->date_naissance = $request->date_naissance;
        $resources->telephone = $request->telephone;
        $resources->sexe = $request->sexe;
        $resources->email = $request->email;
        $resources->password = $request->password;
        $resources->role = $request->role;
        $resources->update();  

        
        Session::put('nomupdate', $request->nom_prenom);
        Session::put('emailupdate', $request->email);
        Session::put('passwordupdate', $request->password);
        // Envoyer la notification d'inscription
        Mail::to($request->email)->send(new UpdateMail());

        
        // Rediriger vers la bonne route en fonction du rôle de l'utilisateur
        if ($resources->role === 'patient') {
            return redirect()->route('patient')->with('status', 'Le patient a été modifié avec succès.');
        }
        if ($resources->role === 'infirmiere') {
            return redirect()->route('infirmiere')->with('status', 'L\'infirmiere a été modifié avec succès.');
        }
        if ($resources->role === 'medecin') {
            return redirect()->route('medecin')->with('status', 'Le medecin a été modifié avec succès.');
        }
        if ($resources->role === 'charge_acceuil') {
            return redirect()->route('CA')->with('status', 'La charge d\'acceuil a été modifié avec succès.');
        }
        if ($resources->role === 'laborantin') {
            return redirect()->route('labo')->with('status', 'La charge d\'acceuil a été modifié avec succès.');
        }
        if ($resources->role === 'pharmacien') {
            return redirect()->route('pharmacien')->with('status', 'Le pharmacien a été ajouté avec succès.');
        }
        
    }

    public function delete_id_resources($id)
    {
        try {
            
            $resources = Resource::findOrFail($id);
            $resources->delete();
            
            // Rediriger vers la bonne route en fonction du rôle de l'utilisateur
            if ($resources->role === 'patient') {
                return redirect()->route('patient')->with('status', 'Le patient a été supprimé avec succès.');
            }
            if ($resources->role === 'infirmiere') {
                return redirect()->route('infirmiere')->with('status', 'L\'infirmiere a été supprimé avec succès.');
            }
            if ($resources->role === 'medecin') {
                return redirect()->route('medecin')->with('status', 'Le medecin a été supprimé avec succès.');
            }
            if ($resources->role === 'charge_acceuil') {
                return redirect()->route('CA')->with('status', 'La charge d\'acceuil a été supprimé avec succès.');
            }
            if ($resources->role === 'laborantin') {
                return redirect()->route('labo')->with('status', 'La charge d\'acceuil a été supprimé avec succès.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) { // Erreur de contrainte de clé étrangère
                return redirect()->back()->with('status', 'Impossible de supprimer ce patient car il est lié à un dossier médical.');
            } else {
                return redirect()->back()->with('status', 'Une erreur est survenue lors de la suppression du patient.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'Une erreur inattendue est survenue.');
        }
    }
}
