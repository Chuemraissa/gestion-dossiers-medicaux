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
    
    public function patient()
    {
        return $this->belongsTo(Resource::class, 'patient_id');
    }

    public function medecin()
    {
        return $this->belongsTo(Resource::class, 'medecin_id');
    }
}
