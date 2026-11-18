<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulter;
use App\Models\Resource;
use App\Models\Ordonnance;
use App\Models\Faire;
use App\Models\Param;
use App\Models\Antecedent;
use App\Models\Examen;
use Illuminate\Support\Facades\DB;

class ConsultationsController extends Controller
{
    public function listesconsultations()
    {
        $consulters = Consulter::all();
        $patients = Resource::where('role', 'patient')->get();
        $medecins = Resource::where('role', 'medecin')->get();
        return view('consultation.listesconsultations', compact('consulters','medecins','patients'));
    }

    public function ajout_consultation(Request $request)
    {
        $request->validate([
            'motif' => 'required',
            'type' => 'required',
            'symptome' => 'required',
            'diagnostic' => 'required',
            'patient' => 'required',
            'cout' => 'required',
        ]);
    
            $consulter = new Consulter();
            $consulter->motif = $request->motif;
            $consulter->type = $request->type;
            $consulter->symptome = $request->symptome;
            $consulter->diagnostic = $request->diagnostic;
            $consulter->patient_id = $request->patient;
            $consulter->medecin_id = session('id');
            $consulter->cout = $request->cout;
            $consulter->save();
    
        return redirect('/listesconsultations')->with('status', 'L\'utilisateur, les paramètres et les antécédents ont été ajoutés avec succès.');
    }
    
    public function update_id_consultation($id)
    {
        $consulters = Consulter::find($id);
        $patients = Resource::where('role', 'patient')->get();
        return view('consultation.updateconsultations', compact('consulters','patients'));
    }

    public function update_consultation_traitement(Request $request)
    {
        $request->validate([
            'motif' => 'required',
            'type' => 'required',
            'symptome' => 'required',
            'diagnostic' => 'required',
            'patient' => 'required',
            'cout' => 'required',
        ]);
    
            $consulter = Consulter::find($request->id);
            $consulter->motif = $request->motif;
            $consulter->type = $request->type;
            $consulter->symptome = $request->symptome;
            $consulter->diagnostic = $request->diagnostic;
            $consulter->patient_id = $request->patient;
            $consulter->medecin_id = session('id');
            $consulter->cout = $request->cout;
            $consulter->update();  

        return redirect('/listesconsultations')->with('status', 'L\'utilisateur a ete modifié avec succes.');
        
    }
    
    public function delete_id_consultation($id)
    {
        $consulter = Consulter::find($id);
        $consulter->delete();

        return redirect('/listesconsultations')->with('status', 'L\'utilisateur a ete supprimé avec succes.');
    }
    
    public function vue_id_consultation($id)
    {
        $resources = Resource::where('role', 'patient')->find($id);
       
        $param = Param::where('resource_id',$resources->id)->first();
        
        $antecedents = Antecedent::where('resource_id',$resources->id)->get();
        return view('consultation.vueconsultaion',['resource'=>$resources,'antecedents'=>$antecedents,'param'=>$param]);
    }

    public function dossier_id_consultation($id)
    {
        $resources = Resource::find($id);
       
       $params = Param::where('resource_id', $resources->id)->get();
        $antecedents = Antecedent::where('resource_id',$resources->id)->get();

        $consultations = Consulter::where('patient_id',$resources->id)->get();
        $ordonnances = Ordonnance::where('patient_id',$resources->id)->with(['medicament','posologie'])->get();
        $effectuers = Faire::where('patient_id',$resources->id)->get();
        $examens = Examen::get();

        
        
        $totalCost = DB::table('examens as e')
            ->join('ordonnances as p', 'e.id', '=', 'p.examen_id')
            ->join('resources as pa', 'p.patient_id', '=', 'pa.id')
            ->where('pa.id', $resources->id)
            ->sum('e.cout');

        $totalMedicament = DB::table('medicaments as e')
            ->join('ordonnances as p', 'e.id', '=', 'p.medicament_id')
            ->join('resources as pa', 'p.patient_id', '=', 'pa.id')
            ->where('pa.id', $resources->id)
            ->sum('e.cout');

        return view('consultation.Dossierconsultation',['resource'=>$resources,'consultations'=>$consultations,
        'ordonnances'=>$ordonnances,'effectuers'=>$effectuers,'antecedents'=>$antecedents,'params'=>$params,
        'examens'=>$examens,'totalCost'=>$totalCost,'totalMedicament'=>$totalMedicament]);
    }
    
}
