<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ElementListe;
use App\Models\Antecedent;
use App\Models\Resource;

class AntecedentsController extends Controller
{
    public function listeantecedent()
    {
        $antecedents = Antecedent::all();
        $resources = Resource::patients()->get();
        return view('patients.listespatients', compact('antecedents', 'resources'));
    }

    public function ajout_antecedent(Request $request)
    {
        $request->validate([
            'patient' => 'required|exists:resources,id',
            'type_antecedent' => ['required', Rule::in(ElementListe::valeurs('types_antecedent'))],
            'description_antecedent' => 'required',
        ]);
        
            $antecedent = new Antecedent();
            $antecedent->type = $request->type_antecedent;
            $antecedent->description = $request->description_antecedent;
            $antecedent->resource_id = $request->patient;
            $antecedent->save();
        
    
        return redirect('/listeantecedents')->with('status', 'Les antécédents ont été ajoutés avec succès.');
    }
    
    public function update_id_antecedent($id)
    {
        $antecedents = Antecedent::findOrFail($id);
        $resources = Resource::patients()->get();
        return view('patients.updateantecedents', compact('antecedents','resources'));
    }

    public function update_antecedent_traitement(Request $request)
    {
        $request->validate([
            'patient' => 'required|exists:resources,id',
            'type_antecedent' => 'required',
            'description_antecedent' => 'required',

        ]);

        $antecedent = Antecedent::findOrFail($request->id);
        $antecedent->type = $request->type_antecedent;
        $antecedent->description = $request->description_antecedent;
        $antecedent->resource_id = $request->patient;
        $antecedent->update();  

        return redirect('/listeantecedents')->with('status', 'L\'utilisateur a ete modifié avec succes.');
        
    }
    
    public function delete_id_antecedent($id)
    {
        $antecedent = Antecedent::findOrFail($id);
        $antecedent->delete();

        return redirect('/listeantecedents')->with('status', 'L\'utilisateur a ete supprimé avec succes.');
    }
}
