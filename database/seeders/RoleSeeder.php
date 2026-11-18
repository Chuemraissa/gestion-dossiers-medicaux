<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Rôles et accès chargés à l'installation.
 * Ensuite, ils se modifient directement dans les tables "roles" et "role_acces".
 *
 * Un rôle déjà présent en base n'est pas modifié : relancer le seeder
 * ne remet pas en place un accès qui a été retiré volontairement.
 *
 * Accès disponibles :
 *  tableau_de_bord           accueil et aide
 *  gestion_personnel         comptes du personnel (création, modification, suppression)
 *  patients                  liste des patients, paramètres, antécédents
 *  consultations             consultations et dossiers médicaux
 *  consultations_suppression supprimer une consultation
 *  ordonnances               voir, imprimer les ordonnances, certificats
 *  prescription              rédiger, modifier, supprimer une ordonnance (= médecin)
 *  rendez_vous               rendez-vous et planning
 *  rendez_vous_suppression   supprimer un rendez-vous
 *  examens                   voir les examens et leurs résultats
 *  examens_gestion           ajouter, modifier, supprimer examens et résultats
 *  medicaments               voir les médicaments, catégories, posologies
 *  medicaments_gestion       ajouter, modifier, supprimer des médicaments
 *  categories_gestion        ajouter, modifier, supprimer catégories et posologies
 *  voir_medecin              voir le médecin responsable dans les listes
 *  voir_laborantin           voir le laborantin dans les résultats d'examens
 */
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin' => [
                'libelle' => 'Administrateur',
                'acces' => [
                    'tableau_de_bord', 'gestion_personnel', 'patients', 'consultations', 'consultations_suppression',
                    'ordonnances', 'prescription', 'rendez_vous', 'rendez_vous_suppression', 'examens',
                    'examens_gestion', 'medicaments', 'medicaments_gestion', 'categories_gestion',
                    'voir_medecin', 'voir_laborantin',
                ],
            ],
            'medecin' => [
                'libelle' => 'Médecin',
                'acces' => [
                    'tableau_de_bord', 'patients', 'consultations', 'consultations_suppression', 'ordonnances',
                    'prescription', 'rendez_vous', 'rendez_vous_suppression', 'examens', 'examens_gestion',
                    'medicaments', 'medicaments_gestion', 'categories_gestion', 'voir_laborantin',
                ],
            ],
            'infirmiere' => [
                'libelle' => 'Infirmière',
                'acces' => [
                    'tableau_de_bord', 'patients', 'consultations', 'ordonnances', 'rendez_vous', 'examens',
                    'medicaments', 'medicaments_gestion', 'categories_gestion',
                ],
            ],
            'laborantin' => [
                'libelle' => 'Laborantin',
                'acces' => ['tableau_de_bord', 'ordonnances', 'examens', 'examens_gestion', 'medicaments'],
            ],
            'pharmacien' => [
                'libelle' => 'Pharmacien',
                'acces' => ['tableau_de_bord', 'medicaments', 'medicaments_gestion'],
            ],
            'charge_acceuil' => [
                'libelle' => "Chargé d'accueil",
                'acces' => ['tableau_de_bord', 'patients'],
            ],
            'patient' => [
                'libelle' => 'Patient',
                'est_patient' => true,
                'acces' => [],
            ],
        ];

        foreach ($roles as $code => $donnees) {
            $role = Role::firstOrCreate(
                ['code' => $code],
                ['libelle' => $donnees['libelle'], 'est_patient' => $donnees['est_patient'] ?? false]
            );

            if ($role->wasRecentlyCreated) {
                foreach ($donnees['acces'] as $acces) {
                    $role->acces()->create(['acces' => $acces]);
                }
            }
        }
    }
}
