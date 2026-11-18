<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;

class Medicament extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'quantite',
        'categorie_id',
        'cout',
    ];
    
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
    
    public function ordonnances()
    {
       return $this->hasMany(Ordonnance::class); 
    }
}