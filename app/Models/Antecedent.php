<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resource;

class Antecedent extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'description',
        'resource_id',
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
