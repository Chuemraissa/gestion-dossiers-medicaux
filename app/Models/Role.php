<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'code',
        'libelle',
        'est_patient',
    ];

    protected $casts = [
        'est_patient' => 'boolean',
    ];

    /** Résultats gardés en mémoire le temps d'une requête (évite de relire la base) */
    private static array $memoire = [];

    public function acces(): HasMany
    {
        return $this->hasMany(RoleAcces::class);
    }

    /**
     * Liste des accès d'un rôle, ex. ['patients', 'consultations'].
     */
    public static function accesDuRole(?string $code): array
    {
        if (! $code) {
            return [];
        }

        return self::$memoire['acces'][$code] ??= RoleAcces::whereHas('role', fn ($q) => $q->where('code', $code))
            ->pluck('acces')
            ->all();
    }

    /**
     * Codes des rôles qui possèdent un accès donné.
     */
    public static function codesAvecAcces(string $acces): array
    {
        return self::$memoire['codes'][$acces] ??= self::whereHas('acces', fn ($q) => $q->where('acces', $acces))
            ->pluck('code')
            ->all();
    }

    /**
     * Code du rôle attribué aux patients.
     */
    public static function codePatient(): ?string
    {
        return self::$memoire['patient'] ??= self::where('est_patient', true)->value('code');
    }

    /**
     * Rôles du personnel (tous sauf le rôle patient).
     */
    public static function personnel()
    {
        return self::where('est_patient', false)->orderBy('libelle')->get();
    }
}
