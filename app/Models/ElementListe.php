<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Un choix d'une liste de formulaire (table "listes").
 * Exemple : ElementListe::options('statuts_rdv')
 */
class ElementListe extends Model
{
    protected $table = 'listes';

    protected $fillable = [
        'liste',
        'valeur',
        'libelle',
        'ordre',
    ];

    /** Listes gardées en mémoire le temps d'une requête */
    private static array $memoire = [];

    /**
     * Tous les choix d'une liste, dans l'ordre.
     */
    public static function options(string $liste): Collection
    {
        return self::$memoire[$liste] ??= self::where('liste', $liste)
            ->orderBy('ordre')
            ->orderBy('libelle')
            ->get();
    }

    /**
     * Valeurs autorisées d'une liste (pour la validation des formulaires).
     */
    public static function valeurs(string $liste): array
    {
        return self::options($liste)->pluck('valeur')->all();
    }

    /**
     * Texte à afficher pour une valeur (la valeur elle-même si elle n'est pas dans la liste).
     */
    public static function libelle(string $liste, ?string $valeur): ?string
    {
        $libelle = self::options($liste)->firstWhere('valeur', $valeur)?->libelle;

        // Le libellé est traduit s'il existe dans lang/*.json, sinon affiché tel quel
        return $libelle !== null ? __($libelle) : $valeur;
    }
}
