<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resource;

class Param extends Model
{
    use HasFactory;

    protected $fillable = [
        'poids',
        'taille',
        'temperature',
        'pression_arterielle',
        'groupe_sanguin',
        'resource_id',
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
