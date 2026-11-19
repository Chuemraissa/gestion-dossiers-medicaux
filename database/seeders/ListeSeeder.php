<?php

namespace Database\Seeders;

use App\Models\ElementListe;
use Illuminate\Database\Seeder;

/**
 * Listes de choix chargées à l'installation (table "listes").
 * Ensuite, elles se modifient directement en base.
 * Une liste déjà présente en base n'est pas modifiée.
 */
class ListeSeeder extends Seeder
{
    public function run(): void
    {
        $listes = [
            'statuts_rdv' => [
                'en_attente' => 'En attente',
                'confirme' => 'Confirmé',
                'annule' => 'Annulé',
                'traite' => 'Traité',
            ],
            'types_examen' => [
                'biopsies' => 'Biopsies',
                'neurophysiologiques' => 'Neurophysiologiques',
                'echographie' => 'Échographie',
                'bacteriologique' => 'Bactériologique',
                'autres' => 'Autres',
            ],
            'types_consultation' => [
                'pediatrique' => 'Pédiatrique',
                'gynecologue' => 'Gynécologique',
                'anesthesie' => 'Anesthésie',
                'psychiatrique' => 'Psychiatrique',
                'autres' => 'Autres',
            ],
            'types_antecedent' => [
                'medicaux' => 'Médicaux',
                'chirurgicaux' => 'Chirurgicaux',
                'familiaux' => 'Familiaux',
                'autres' => 'Autres',
            ],
            'groupes_sanguins' => [
                'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-',
                'AB+' => 'AB+', 'AB-' => 'AB-', 'O+' => 'O+', 'O-' => 'O-',
            ],
            'tarifs_consultation' => [
                '1500' => '1500',
                '2000' => '2000',
                '2500' => '2500',
                '3000' => '3000',
                '3500' => '3500',
            ],
        ];

        foreach ($listes as $liste => $elements) {
            if (ElementListe::where('liste', $liste)->exists()) {
                continue;
            }

            $ordre = 0;
            foreach ($elements as $valeur => $libelle) {
                ElementListe::create([
                    'liste' => $liste,
                    'valeur' => $valeur,
                    'libelle' => $libelle,
                    'ordre' => $ordre++,
                ]);
            }
        }
    }
}
