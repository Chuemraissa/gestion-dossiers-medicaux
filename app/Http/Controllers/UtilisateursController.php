<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Models\Resource;
use App\Models\Role;
use App\Models\Rendez_vous;
use App\Models\Medicament;
use App\Models\Examen;
use App\Models\Consulter;
use App\Mail\WelcomeMail;
use App\Mail\UpdateMail;

class UtilisateursController extends Controller
{
    public function acceuil()
    {
        if (auth()->user()->estPatient()) {
            return redirect('/dossier/'.auth()->id());
        }

        $patientCount = Resource::patients()->count();
        // Médecins : comptes qui prescrivent, sans compter les administrateurs
        $medecinCount = Resource::medecins()
            ->whereNotIn('role', Role::codesAvecAcces('gestion_personnel'))
            ->count();
        $rdvCount = Rendez_vous::count();
        $consulterCount = Consulter::count();
        $medCount = Medicament::count();
        $examenCount = Examen::count();

        return view('patients.acceuil', compact('patientCount', 'medecinCount', 'rdvCount', 'consulterCount', 'medCount', 'examenCount'));
    }

    public function aide()
    {
        return view('aide.aide');
    }

    /**
     * Liste du personnel, un onglet par rôle (les rôles viennent de la table "roles").
     */
    public function listeresources(?string $role = null)
    {
        $roles = Role::personnel();
        $roleActif = $roles->firstWhere('code', $role) ?? $roles->first();
        $resources = $roleActif ? Resource::where('role', $roleActif->code)->get() : collect();

        return view('resourceshumaines.listesresources', compact('roles', 'roleActif', 'resources'));
    }

    public function ajout_resources(Request $request)
    {
        $request->validate([
            'nom_prenom' => 'required',
            'date_naissance' => 'required|date',
            'adresse' => 'required',
            'telephone' => 'required',
            'sexe' => 'required',
            'email' => 'required|email|unique:resources,email',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|exists:roles,code',
        ]);

        $this->verifierDroitSurRole($request->role);

        $resource = new Resource();
        $resource->nom_prenom = $request->nom_prenom;
        $resource->adresse = $request->adresse;
        $resource->date_naissance = $request->date_naissance;
        $resource->telephone = $request->telephone;
        $resource->sexe = $request->sexe;
        $resource->email = $request->email;
        $resource->password = $request->password;
        $resource->role = $request->role;
        $resource->save();

        // Données lues par le modèle d'e-mail, effacées juste après l'envoi
        Session::put('nom', $request->nom_prenom);
        Session::put('email', $request->email);
        Session::put('password', $request->password);
        $this->envoyerMail($request->email, new WelcomeMail());
        Session::forget(['nom', 'email', 'password']);

        return $this->retourListe($resource->role, 'ajouté');
    }

    public function update_id_resources($id)
    {
        $resources = Resource::findOrFail($id);
        $this->verifierDroitSurRole($resources->role);

        // Rôles proposés : tous pour l'admin, seulement « patient » pour les autres
        $roles = $this->aAcces('gestion_personnel')
            ? Role::orderBy('libelle')->get()
            : Role::where('est_patient', true)->get();

        return view('resourceshumaines.updateresources', compact('resources', 'roles'));
    }

    public function update_resources_traitement(Request $request)
    {
        $resource = Resource::findOrFail($request->id);

        $request->validate([
            'nom_prenom' => 'required',
            'date_naissance' => 'required|date',
            'adresse' => 'required',
            'telephone' => 'required',
            'sexe' => 'required',
            'email' => ['required', 'email', Rule::unique('resources', 'email')->ignore($resource->id)],
            // Laisser le mot de passe vide pour garder l'ancien
            'password' => 'nullable|confirmed|min:8',
            'role' => 'required|exists:roles,code',
        ]);

        $this->verifierDroitSurRole($resource->role);
        $this->verifierDroitSurRole($request->role);

        $resource->nom_prenom = $request->nom_prenom;
        $resource->adresse = $request->adresse;
        $resource->date_naissance = $request->date_naissance;
        $resource->telephone = $request->telephone;
        $resource->sexe = $request->sexe;
        $resource->email = $request->email;
        if ($request->filled('password')) {
            $resource->password = $request->password;
        }
        $resource->role = $request->role;
        $resource->save();

        Session::put('nomupdate', $request->nom_prenom);
        Session::put('emailupdate', $request->email);
        Session::put('passwordupdate', $request->filled('password') ? $request->password : 'inchangé');
        $this->envoyerMail($request->email, new UpdateMail());
        Session::forget(['nomupdate', 'emailupdate', 'passwordupdate']);

        return $this->retourListe($resource->role, 'modifié');
    }

    public function delete_id_resources($id)
    {
        $resource = Resource::findOrFail($id);
        $this->verifierDroitSurRole($resource->role);

        if ($resource->id === auth()->id()) {
            return redirect()->back()->with('status', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        try {
            $resource->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('status', 'Impossible de supprimer ce compte : il est lié à des dossiers médicaux, consultations ou rendez-vous.');
        }

        return $this->retourListe($resource->role, 'supprimé');
    }

    /**
     * Seuls les rôles qui ont l'accès « gestion_personnel » peuvent créer ou modifier
     * un compte du personnel. Les autres (ex. chargé d'accueil) ne gèrent que les patients.
     */
    private function verifierDroitSurRole(?string $role): void
    {
        if (! $this->aAcces('gestion_personnel') && $role !== Role::codePatient()) {
            abort(403, 'Vous ne pouvez gérer que les comptes patients.');
        }
    }

    /**
     * Après une action : retour à la liste des patients ou à l'onglet du rôle concerné.
     */
    private function retourListe(?string $role, string $action)
    {
        $message = "Le compte a été {$action} avec succès.";

        if ($role === Role::codePatient() || ! $this->aAcces('gestion_personnel')) {
            return redirect()->route('patient')->with('status', $message);
        }

        return redirect()->route('personnel', $role)->with('status', $message);
    }
}
