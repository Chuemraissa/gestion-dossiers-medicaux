<?php

namespace App\View\Components;

use App\Models\ElementListe;
use Illuminate\View\Component;

/**
 * Affiche les <option> d'une liste de la table "listes".
 * Exemple : <x-options-liste liste="statuts_rdv" :selection="$rdv->statut" />
 */
class OptionsListe extends Component
{
    public function __construct(
        public string $liste,
        public ?string $selection = null,
    ) {
    }

    public function render()
    {
        return view('components.options-liste', [
            'options' => ElementListe::options($this->liste),
        ]);
    }
}
