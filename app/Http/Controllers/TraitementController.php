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
        $laborantins = Resource::avecAcces('examens_gestion')->get();
        $patients = Resource::patients()->get();
        $examens = Examen::all();
        return view('ordonnance.listestraitements', compact('effectuers','laborantins','examens','patients'));
    }

    public function ajout_traitement(Request $request)
    {
        $request->validate([
            'patient' => 'required|exists:resources,id',
            'type' => 'required|exists:examens,id',
            'resultat' => 'required',
        ]); 

        $faire = new Faire();
        $faire->laborantin_id = auth()->id();
        $faire->examen_id = $request->type;
        $faire->patient_id = $request->patient;
        $faire->resultat = $request->resultat;
        $faire->save();

        return redirect('/listestraitements')->with('status', __('Le résultat d\'examen a été ajouté avec succès.'));
    }
    
    public function update_id_traitement($id)
    {
        $effectuers = Faire::findOrFail($id);
        $patients = Resource::patients()->get();
        $examens = Examen::all();
        return view('examen.updateFaires', compact('effectuers','examens','patients'));
    }

    public function update_traitement_traitement(Request $request)
    {
        $request->validate([
            'patient' => 'required|exists:resources,id',
            'type' => 'required|exists:examens,id',
            'resultat' => 'required',
        ]);

        $faire = Faire::findOrFail($request->id);
        $faire->laborantin_id = auth()->id();
        $faire->examen_id = $request->type;
        $faire->patient_id = $request->patient;
        $faire->resultat = $request->resultat;
        $faire->update();  

        return redirect('/listestraitements')->with('status', __('Le résultat d\'examen a été modifié avec succès.'));
        
    }

    public function delete_id_traitement($id)
    {
        $Faire = Faire::findOrFail($id);
        $Faire->delete();

        return redirect('/listestraitements')->with('status', __('Le résultat d\'examen a été supprimé avec succès.'));
    }

}