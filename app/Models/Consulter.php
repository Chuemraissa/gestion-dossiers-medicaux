<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulter extends Model
{
    use HasFactory;

    protected $fillable = [
        'motif',
        'type',
        'symptome',
        'diagnostic',
        'patient_id',
        'medecin_id',
        'cout',
    ];
    
    public function resources()
    {
       return $this->belongsToMany(Resource::class); 
    }
}
