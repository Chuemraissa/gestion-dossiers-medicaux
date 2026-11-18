<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Param;

class ParamsController extends Controller
{
    public function listeparams()
    {
        $params = Param::all();
        $resources = Resource::where('role', 'patient')->get();
        return view('patients.listespatients', compact('params', 'resources'));
    }

    public function ajout_param(Request $request)
    {
        $request->validate([
            'patient' => 'required',
            'poids' => 'required',
            'taille' => 'required',
            'temperature' => 'required',
            'pression_arterielle' => 'required',
            'groupe_sanguin' => 'required',
        ]);
    
            $param = new Param();
            $param->poids = $request->poids;
            $param->taille = $request->taille;
            $param->temperature = $request->temperature;
            $param->pression_arterielle = $request->pression_arterielle;
            $param->groupe_sanguin = $request->groupe_sanguin;
            $param->resource_id = $request->patient;
            $param->save();      
    
        return redirect('/listeparams')->with('status', 'Le paramètre a été ajouté avec succès.');
    }
     
    public function update_id_param($id)
    {
        $params = Param::find($id);
        $resources = Resource::all();
        return view('patients.updateparams', compact('params','resources'));
    }

    public function update_param_traitement(Request $request)
    {
        $request->validate([
            'patient' => 'required',
            'poids' => 'required',
            'taille' => 'required',
            'temperature' => 'required',
            'pression_arterielle' => 'required',
            'groupe_sanguin' => 'required',
        ]);

        
        $param = Param::find($request->id);
        $param->poids = $request->poids;
        $param->taille = $request->taille;
        $param->temperature = $request->temperature;
        $param->pression_arterielle = $request->pression_arterielle;
        $param->groupe_sanguin = $request->groupe_sanguin;
        $param->resource_id = $request->patient;
        $param->update();  

        return redirect('/listeparams')->with('status', 'Le parametre a ete modifié avec succes.');
        
    }
    
    public function delete_id_param($id)
    {
        $param = Param::find($id);
        $param->delete();

        return redirect('/listeparams')->with('status', 'Le parametre a ete supprimé avec succes.');
    }
}
