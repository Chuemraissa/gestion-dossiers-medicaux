<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faire;
use App\Models\Resource;
use App\Models\Examen;

class TraitementController extends Controller
{
    public function listetraitement()
    {
        $effectuers = Faire::all();        
        $laborantins = Resource::where('role', ['admin', 'medecin', 'laborantin'])->get();
        $patients = Resource::where('role', 'patient')->get();
        $examens = Examen::all();
        return view('ordonnance.listestraitements', compact('effectuers','laborantins','examens','patients'));
    }

    public function ajout_traitement(Request $request)
    {
        $request->validate([
            'patient' => 'required',
            'type' => 'required',
            'resultat' => 'required',
        ]); 

        $faire = new Faire();
        $faire->laborantin_id = session('id');
        $faire->examen_id = $request->type;
        $faire->patient_id = $request->patient;
        $faire->resultat = $request->resultat;
        $faire->save();

        return redirect('/listestraitements');
    }
    
    public function update_id_traitement($id)
    {
        $effectuers = Faire::find($id);
        $patients = Resource::where('role', 'patient')->get();
        $examens = Examen::all();
        return view('examen.updateFaires', compact('effectuers','examens','patients'));
    }

    public function update_traitement_traitement(Request $request)
    {
        $request->validate([
            'patient' => 'required',
            'type' => 'required',
            'resultat' => 'required',
        ]);

        $faire = Faire::find($request->id);
        $faire->laborantin_id = session('id');
        $faire->examen_id = $request->type;
        $faire->patient_id = $request->patient;
        $faire->resultat = $request->resultat;
        $faire->update();  

        return redirect('/listestraitements');
        
    }

    public function delete_id_traitement($id)
    {
        $Faire = Faire::find($id);
        $Faire->delete();

        return redirect('/listestraitements')->with('status', 'Le laborantin a ete supprimé avec succes.');
    }

}