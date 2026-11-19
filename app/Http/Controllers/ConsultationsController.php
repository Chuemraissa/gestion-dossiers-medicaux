<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ElementListe;
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
        $patients = Resource::patients()->get();
        $medecins = Resource::medecins()->get();
        return view('consultation.listesconsultations', compact('consulters','medecins','patients'));
    }

    public function ajout_consultation(Request $request)
    {
        $request->validate([
            'motif' => 'required',
            'type' => ['required', Rule::in(ElementListe::valeurs('types_consultation'))],
            'symptome' => 'required',
            'diagnostic' => 'required',
            'patient' => 'required|exists:resources,id',
            'cout' => 'required|numeric|min:0',
        ]);
    
            $consulter = new Consulter();
            $consulter->motif = $request->motif;
            $consulter->type = $request->type;
            $consulter->symptome = $request->symptome;
            $consulter->diagnostic = $request->diagnostic;
            $consulter->patient_id = $request->patient;
            $consulter->medecin_id = auth()->id();
            $consulter->cout = $request->cout;
            $consulter->save();
    
        return redirect('/listesconsultations')->with('status', 'L\'utilisateur, les paramètres et les antécédents ont été ajoutés avec succès.');
    }
    
    public function update_id_consultation($id)
    {
        $consulters = Consulter::findOrFail($id);
        $patients = Resource::patients()->get();
        return view('consultation.updateconsultations', compact('consulters','patients'));
    }

    public function update_consultation_traitement(Request $request)
    {
        $request->validate([
            'motif' => 'required',
            'type' => 'required',
            'symptome' => 'required',
            'diagnostic' => 'required',
            'patient' => 'required|exists:resources,id',
            'cout' => 'required|numeric|min:0',
        ]);
    
            $consulter = Consulter::findOrFail($request->id);
            $consulter->motif = $request->motif;
            $consulter->type = $request->type;
            $consulter->symptome = $request->symptome;
            $consulter->diagnostic = $request->diagnostic;
            $consulter->patient_id = $request->patient;
            $consulter->medecin_id = auth()->id();
            $consulter->cout = $request->cout;
            $consulter->update();  

        return redirect('/listesconsultations')->with('status', 'L\'utilisateur a ete modifié avec succes.');
        
    }
    
    public function delete_id_consultation($id)
    {
        $consulter = Consulter::findOrFail($id);
        $consulter->delete();

        return redirect('/listesconsultations')->with('status', 'L\'utilisateur a ete supprimé avec succes.');
    }
    
    public function vue_id_consultation($id)
    {
        $resources = Resource::patients()->findOrFail($id);

        // Derniers paramètres enregistrés (peut être vide si aucun n'a encore été saisi)
        $param = Param::where('resource_id', $resources->id)->latest()->first();
        $antecedents = Antecedent::where('resource_id', $resources->id)->get();

        return view('consultation.vueconsultaion', ['resource' => $resources, 'antecedents' => $antecedents, 'param' => $param]);
    }

    public function dossier_id_consultation($id)
    {
        $resources = Resource::patients()->findOrFail($id);

        // Un patient ne peut voir que son propre dossier ; le personnel soignant voit tous les dossiers
        $user = auth()->user();
        $estLePatient = $user->estPatient() && (int) $id === $user->id;
        $estSoignant = $user->aAcces('consultations');

        if (! $estLePatient && ! $estSoignant) {
            abort(403, "Vous n'avez pas accès à ce dossier.");
        }
       
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
