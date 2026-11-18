<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resource;
use App\Models\Examen;

class Faire extends Model
{
    use HasFactory;

    protected $fillable = [
        'laborantin_id',
        'examen_id',
        'patient_id',
        'resultat',
    ];
    
    public function resources()
    {
       return $this->belongsToMany(Resource::class); 
    }
    
    public function examen()
    {
       return $this->belongsToMany(Examen::class); 
    }
}
