<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resource;
use App\Models\Medicament;
use App\Models\Posologie;
use App\Models\Examen;

class Ordonnance extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'medicament_id',
        'posologie_id',
        'patient_id',
        'medecin_id',
        'examen_id',
    ];
    
    public function medicament()
    {
        return $this->belongsTo(Medicament::class);
    }
    
    public function posologie()
    {
        return $this->belongsTo(Posologie::class);
    }
        
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
        
    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }
}
