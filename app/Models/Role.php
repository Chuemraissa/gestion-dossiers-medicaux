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

    /**
     * Accès qui existent dans l'application (utilisés par les routes et les pages),
     * avec leur description. Les rôles reçoivent ces accès dans la table role_acces.
     */
    public const ACCES = [
        'tableau_de_bord' => 'Accueil et aide',
        'gestion_personnel' => 'Administration : personnel, rôles, listes, informations de la clinique',
        'patients' => 'Patients, paramètres, antécédents',
        'consultations' => 'Consultations et dossiers médicaux',
        'consultations_suppression' => 'Supprimer une consultation',
        'ordonnances' => 'Voir et imprimer les ordonnances',
        'prescription' => 'Rédiger, modifier, supprimer une ordonnance',
        'rendez_vous' => 'Rendez-vous et planning',
        'rendez_vous_suppression' => 'Supprimer un rendez-vous',
        'examens' => 'Voir les examens et leurs résultats',
        'examens_gestion' => 'Gérer les examens et leurs résultats',
        'medicaments' => 'Voir les médicaments, catégories, posologies',
        'medicaments_gestion' => 'Gérer les médicaments',
        'categories_gestion' => 'Gérer les catégories et posologies',
        'voir_medecin' => 'Voir le médecin responsable dans les listes',
        'voir_laborantin' => 'Voir le laborantin dans les résultats',
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
