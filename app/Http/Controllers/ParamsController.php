<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ElementListe;
use App\Models\Resource;
use App\Models\Param;

class ParamsController extends Controller
{
    public function listeparams()
    {
        $params = Param::all();
        $resources = Resource::patients()->get();
        return view('patients.listespatients', compact('params', 'resources'));
    }

    public function ajout_param(Request $request)
    {
        $request->validate([
            'patient' => 'required|exists:resources,id',
            'poids' => 'required',
            'taille' => 'required',
            'temperature' => 'required',
            'pression_arterielle' => 'required',
            'groupe_sanguin' => ['required', Rule::in(ElementListe::valeurs('groupes_sanguins'))],
        ]);
    
            $param = new Param();
            $param->poids = $request->poids;
            $param->taille = $request->taille;
            $param->temperature = $request->temperature;
            $param->pression_arterielle = $request->pression_arterielle;
            $param->groupe_sanguin = $request->groupe_sanguin;
            $param->resource_id = $request->patient;
            $param->save();      
    
        return redirect('/listeparams')->with('status', __('Les paramètres ont été ajoutés avec succès.'));
    }
     
    public function update_id_param($id)
    {
        $params = Param::findOrFail($id);
        $resources = Resource::patients()->get();
        return view('patients.updateparams', compact('params','resources'));
    }

    public function update_param_traitement(Request $request)
    {
        $request->validate([
            'patient' => 'required|exists:resources,id',
            'poids' => 'required',
            'taille' => 'required',
            'temperature' => 'required',
            'pression_arterielle' => 'required',
            'groupe_sanguin' => 'required',
        ]);

        
        $param = Param::findOrFail($request->id);
        $param->poids = $request->poids;
        $param->taille = $request->taille;
        $param->temperature = $request->temperature;
        $param->pression_arterielle = $request->pression_arterielle;
        $param->groupe_sanguin = $request->groupe_sanguin;
        $param->resource_id = $request->patient;
        $param->update();  

        return redirect('/listeparams')->with('status', __('Les paramètres ont été modifiés avec succès.'));
        
    }
    
    public function delete_id_param($id)
    {
        $param = Param::findOrFail($id);
        $param->delete();

        return redirect('/listeparams')->with('status', __('Les paramètres ont été supprimés avec succès.'));
    }
}
