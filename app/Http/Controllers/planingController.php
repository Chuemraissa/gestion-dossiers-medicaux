<?php

namespace App\Http\Controllers;
use App\Models\Rendez_vous;
use Illuminate\Http\Request;

class planingController extends Controller
{
    
    public function index()
    {
        $rendezVous = Rendez_vous::all();
        $events = [];
        foreach ($rendezVous as $rv) {
            $events[] = [
                'title' => $rv->patient_id,
                'start' => $rv->date . ' ' . $rv->heure,
                'end' => date('Y-m-d H:i:s', strtotime($rv->date . ' ' . $rv->heure) + 3600), // Ajout d'1 heure
            ];
        }
        return view('planing.index', compact('events'));
    }
}
