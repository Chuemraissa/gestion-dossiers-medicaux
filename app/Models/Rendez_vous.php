<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resource;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderEmail;
use Carbon\Carbon;

class Rendez_vous extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'heure',
        'statut',
        'motif',
        'patient_id',
        'medecin_id',
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
