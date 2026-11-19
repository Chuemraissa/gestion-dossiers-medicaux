<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Réglage de l'établissement (table "parametres").
 * Exemple : Parametre::valeur('clinique_nom')
 */
class Parametre extends Model
{
    protected $fillable = [
        'cle',
        'valeur',
    ];

    /** Réglages gardés en mémoire le temps d'une requête */
    private static ?array $memoire = null;

    public static function valeur(string $cle, ?string $parDefaut = null): ?string
    {
        self::$memoire ??= self::pluck('valeur', 'cle')->all();

        return self::$memoire[$cle] ?? $parDefaut;
    }
}
