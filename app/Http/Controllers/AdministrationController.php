<?php

namespace App\Http\Controllers;

use App\Models\ElementListe;
use App\Models\Parametre;
use App\Models\Resource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Écrans d'administration : rôles et accès, listes de choix, informations de la clinique.
 * Réservés aux rôles qui ont l'accès « gestion_personnel ».
 */
class AdministrationController extends Controller
{
    /** Noms affichés des listes de la table "listes" */
    private const LISTES = [
        'statuts_rdv' => 'Statuts des rendez-vous',
        'types_examen' => "Types d'examen",
        'types_consultation' => 'Types de consultation',
        'types_antecedent' => "Types d'antécédent",
        'groupes_sanguins' => 'Groupes sanguins',
        'tarifs_consultation' => 'Tarifs des consultations',
    ];

    /** Informations de la clinique modifiables (table "parametres") */
    private const PARAMETRES = [
        'clinique_nom' => "Nom de l'établissement",
        'clinique_adresse' => 'Adresse',
        'clinique_region' => 'Région et pays',
        'clinique_telephone' => "Téléphone de l'établissement",
        'support_telephone' => "Téléphone d'assistance (page Aide)",
    ];

    // ---------- Rôles et accès ----------

    public function roles()
    {
        return view('administration.roles', [
            'roles' => Role::with('acces')->orderBy('libelle')->get(),
            'acces' => Role::ACCES,
        ]);
    }

    public function enregistrerRoles(Request $request)
    {
        $choix = $request->input('acces', []); // [role_id => [code, ...]]
        $roleConnecte = auth()->user()->role;

        DB::transaction(function () use ($choix, $roleConnecte) {
            foreach (Role::all() as $role) {
                $codes = array_values(array_intersect(array_keys(Role::ACCES), (array) ($choix[$role->id] ?? [])));

                // Sécurité : on ne retire pas l'administration à son propre rôle (sinon plus personne ne peut administrer)
                if ($role->code === $roleConnecte && ! in_array('gestion_personnel', $codes, true)) {
                    $codes[] = 'gestion_personnel';
                }

                $role->acces()->delete();
                foreach ($codes as $code) {
                    $role->acces()->create(['acces' => $code]);
                }
            }
        });

        return redirect()->route('admin.roles')->with('status', __('Les accès ont été enregistrés.'));
    }

    public function ajouterRole(Request $request)
    {
        $request->validate([
            'code' => ['required', 'alpha_dash', 'max:50', 'unique:roles,code'],
            'libelle' => ['required', 'max:100'],
        ]);

        Role::create(['code' => $request->code, 'libelle' => $request->libelle, 'est_patient' => false]);

        return redirect()->route('admin.roles')->with('status', __('Le rôle a été ajouté.'));
    }

    public function supprimerRole($id)
    {
        $role = Role::findOrFail($id);

        if ($role->est_patient || Resource::where('role', $role->code)->exists()) {
            return redirect()->route('admin.roles')
                ->with('status', __('Ce rôle ne peut pas être supprimé : il est utilisé par des comptes.'));
        }

        $role->delete();

        return redirect()->route('admin.roles')->with('status', __('Le rôle a été supprimé.'));
    }

    // ---------- Listes de choix ----------

    public function listes(?string $liste = null)
    {
        $liste = array_key_exists($liste, self::LISTES) ? $liste : array_key_first(self::LISTES);

        return view('administration.listes', [
            'listes' => self::LISTES,
            'listeActive' => $liste,
            'elements' => ElementListe::where('liste', $liste)->orderBy('ordre')->orderBy('libelle')->get(),
        ]);
    }

    public function ajouterElement(Request $request)
    {
        $request->validate([
            'liste' => ['required', Rule::in(array_keys(self::LISTES))],
            'valeur' => ['required', 'max:50', Rule::unique('listes', 'valeur')->where('liste', $request->liste)],
            'libelle' => ['required', 'max:100'],
            'ordre' => ['nullable', 'integer', 'min:0'],
        ]);

        ElementListe::create($request->only('liste', 'valeur', 'libelle') + ['ordre' => (int) $request->ordre]);

        return redirect()->route('admin.listes', $request->liste)->with('status', __('Le choix a été ajouté.'));
    }

    public function modifierElement(Request $request, $id)
    {
        $element = ElementListe::findOrFail($id);

        // La valeur n'est pas modifiable : elle est déjà enregistrée dans les dossiers existants
        $request->validate([
            'libelle' => ['required', 'max:100'],
            'ordre' => ['nullable', 'integer', 'min:0'],
        ]);

        $element->update(['libelle' => $request->libelle, 'ordre' => (int) $request->ordre]);

        return redirect()->route('admin.listes', $element->liste)->with('status', __('Le choix a été modifié.'));
    }

    public function supprimerElement($id)
    {
        $element = ElementListe::findOrFail($id);
        $element->delete();

        return redirect()->route('admin.listes', $element->liste)->with('status', __('Le choix a été supprimé.'));
    }

    // ---------- Informations de la clinique ----------

    public function parametres()
    {
        return view('administration.parametres', [
            'champs' => self::PARAMETRES,
            'valeurs' => Parametre::pluck('valeur', 'cle'),
        ]);
    }

    public function enregistrerParametres(Request $request)
    {
        $regles = [];
        foreach (array_keys(self::PARAMETRES) as $cle) {
            $regles[$cle] = ['nullable', 'max:255'];
        }
        $request->validate($regles);

        foreach (array_keys(self::PARAMETRES) as $cle) {
            Parametre::updateOrCreate(['cle' => $cle], ['valeur' => $request->input($cle)]);
        }

        return redirect()->route('admin.parametres')->with('status', __('Les informations ont été enregistrées.'));
    }
}
