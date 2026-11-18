<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Param;
use App\Models\Antecedent;
use App\Models\Ordonnance;
use App\Models\Rendez_vous;
use App\Models\Examen;
use App\Models\Consulter;
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
       return $this->hasMany(Ordonnance::class); 
    }

    public function rendez_vouses()
    {
       return $this->hasMany(Rendez_vous::class); 
    }

    public function examens()
    {
       return $this->belongsToMany(Examen::class); 
    }
    
    public function consulters()
    {
       return $this->belongsToMany(Consulter::class); 
    }
}
