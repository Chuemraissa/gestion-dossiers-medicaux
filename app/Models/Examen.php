<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resource;
use App\Models\Faire;
use App\Models\Ordonnance;

class Examen extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'description',
        'cout',
    ];

    


    
    public function faires()
    {
        return $this->hasMany(Faire::class);
    }
    
    public function ordonnances()
    {
       return $this->hasMany(Ordonnance::class); 
    }
}
