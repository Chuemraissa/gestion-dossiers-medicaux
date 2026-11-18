<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antecedent;
use App\Models\Resource;

class AntecedentsController extends Controller
{
    public function listeantecedent()
    {
        $antecedents = Antecedent::all();
        $resources = Resource::where('role', 'patient')->get();
        return view('patients.listespatients', compact('antecedents', 'resources'));
    }

    public function ajout_antecedent(Request $request)
    {
        $request->validate([
            'patient' => 'required',
            'type_antecedent' => 'required',
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
        $antecedents = Antecedent::find($id);
        $resources = Resource::all();
        return view('patients.updateantecedents', compact('antecedents','resources'));
    }

    public function update_antecedent_traitement(Request $request)
    {
        $request->validate([
            'patient' => 'required',
            'type_antecedent' => 'required',
            'description_antecedent' => 'required',

        ]);

        $antecedent = Antecedent::find($request->id);
        $antecedent->type = $request->type_antecedent;
        $antecedent->description = $request->description_antecedent;
        $antecedent->resource_id = $request->patient;
        $antecedent->update();  

        return redirect('/listeantecedents')->with('status', 'L\'utilisateur a ete modifié avec succes.');
        
    }
    
    public function delete_id_antecedent($id)
    {
        $antecedent = Antecedent::find($id);
        $antecedent->delete();

        return redirect('/listeantecedents')->with('status', 'L\'utilisateur a ete supprimé avec succes.');
    }
}
