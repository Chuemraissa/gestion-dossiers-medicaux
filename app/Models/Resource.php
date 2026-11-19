<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Param;
use App\Models\Role;
use App\Models\Antecedent;
use App\Models\Ordonnance;
use App\Models\Rendez_vous;
use App\Models\Consulter;
use App\Models\Faire;
use Illuminate\Notifications\Notifiable;


class Resource extends Model implements AuthenticatableContract
{
   use HasFactory, Authenticatable, Notifiable;

    protected $fillable = [
        'nom_prenom',
        'adresse',
        'date_naissance',
        'telephone',
        'sexe',
        'email',
        'password',
        'role',
    ];

    // Le mot de passe (chiffré) n'est jamais renvoyé quand le modèle est converti en tableau/JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Rôle de ce compte (table "roles").
     */
    public function roleModel()
    {
        return $this->belongsTo(Role::class, 'role', 'code');
    }

    /**
     * Vrai si le rôle de ce compte possède au moins un des accès demandés.
     * Exemple : $user->aAcces('patients')
     */
    public function aAcces(string ...$acces): bool
    {
        return (bool) array_intersect($acces, Role::accesDuRole($this->role));
    }

    public function estPatient(): bool
    {
        return $this->role !== null && $this->role === Role::codePatient();
    }

    /** Resource::patients() : uniquement les comptes patients */
    public function scopePatients($query)
    {
        return $query->where('role', Role::codePatient());
    }

    /** Resource::medecins() : comptes qui peuvent prescrire */
    public function scopeMedecins($query)
    {
        return $query->whereIn('role', Role::codesAvecAcces('prescription'));
    }

    /** Resource::avecAcces('examens_gestion') : comptes dont le rôle a cet accès */
    public function scopeAvecAcces($query, string $acces)
    {
        return $query->whereIn('role', Role::codesAvecAcces($acces));
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Implémentation des méthodes requises par l'interface Authenticatable
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function params()
    {
       return $this->hasMany(Param::class); 
    }

    public function antecedents()
    {
       return $this->hasMany(Antecedent::class); 
    }

    public function ordonnances()
    {
        return $this->hasMany(Ordonnance::class, 'patient_id');
    }

    public function rendez_vouses()
    {
        return $this->hasMany(Rendez_vous::class, 'patient_id');
    }

    public function consulters()
    {
        return $this->hasMany(Consulter::class, 'patient_id');
    }

    public function faires()
    {
        return $this->hasMany(Faire::class, 'patient_id');
    }
}
