<?php

namespace Database\Seeders;

use App\Models\Parametre;
use Illuminate\Database\Seeder;

/**
 * Informations de l'établissement chargées à l'installation (table "parametres").
 * Ensuite, elles se modifient directement en base.
 * Un réglage déjà présent n'est pas modifié.
 */
class ParametreSeeder extends Seeder
{
    public function run(): void
    {
        $parametres = [
            'clinique_nom' => 'Electronical Folder',
            'clinique_adresse' => 'Entrée de Bafoussam, BP 1234',
            'clinique_region' => "Région de l'Ouest, Cameroun",
            'clinique_telephone' => '+237695236548',
            'support_telephone' => '+237699060031',
        ];

        foreach ($parametres as $cle => $valeur) {
            Parametre::firstOrCreate(['cle' => $cle], ['valeur' => $valeur]);
        }
    }
}
