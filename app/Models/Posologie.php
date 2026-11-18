<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ordonnance;

class Posologie extends Model
{
    use HasFactory;

    protected $fillable = [
        'dose',
        'frequence',
        'duree',
    ];
    
    public function ordonnances()
    {
       return $this->hasMany(Ordonnance::class); 
    }
}
