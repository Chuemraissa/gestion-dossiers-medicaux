<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Param;
use App\Models\Antecedent;

class PatientsController extends Controller
{
    public function listepatients()
    {
        $patients = Resource::where('role', 'patient')->get(); 
        return view('patients.listespatients', compact('patients')); 
    }
    
    public function imprimer()
    {
        $patients = Resource::where('role', 'patient')->get();
        return view('patients.imprimer', compact('patients'));
    }
    
    public function show_patient($id){
        $resources = Resource::find($id);
       
        $param = Param::where('resource_id',$resources->id)->get();
        $antecedent = Antecedent::where('resource_id',$resources->id)->get();
        return view('patients.vuepatient',['resource'=>$resources,'antecedents'=>$antecedent,'params'=>$param]);
    }
}
