<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ordonnance;
use App\Models\Medicament;
use App\Models\Posologie;
use App\Models\Resource;
use App\Models\Faire;
use App\Models\Examen;
use App\Mail\NewOrdonnanceMail;
use App\Mail\AttenteNewOrdonnanceMail;
use App\Mail\UpdateOrdonnanceMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OrdonnancesController extends Controller
{         
    public function listeordonnances()
    {
        $ordonnancesAll = Ordonnance::with(['medicament', 'posologie', 'resource'])->get(); 
        $medicaments = Medicament::all();
        $examens = Examen::all();
        $posologies = Posologie::all();
        $patients = Resource::where('role', 'patient')->get();
        $medecins = Resource::where('role', 'medecin')->get();
        return view('ordonnance.listesordonnances',
            compact('ordonnancesAll','medicaments','posologies','patients','medecins','examens'));
    }

    public function certificat($id)
    {
        $ordonnancesAll = Ordonnance::find($id);
        $patient = Resource::where('role', 'patient')->where('id', $ordonnancesAll->patient_id)->first();
        $medecin = Resource::where('role', 'medecin')->first();

        return view('ordonnance.certificat', compact('patient','medecin'));
    }
    
    public function ajout_ordonnance(Request $request)
    {
        $request->validate([
            'description' => 'required',
            // 'medicament'=> 'required',
            'patient' => 'required',
            'examen' => 'required',

            'dose' => 'nullable',
            'frequence' => 'nullable',
            'duree' => 'nullable',
        ]);

        DB::transaction(function () use ($request) {

        $posologie = new Posologie();
        $posologie->dose = $request->dose; 
        $posologie->frequence = $request->frequence;
        $posologie->duree = $request->duree;
        $posologie->save();

        $ordonnace = new Ordonnance();
        $ordonnace->description = $request->description;
        // $ordonnace->medicament_id = $request->medicament;
        $ordonnace->posologie_id = $posologie->id;
        $ordonnace->patient_id = $request->patient;
        $ordonnace->medecin_id = session('id');
        $ordonnace->examen_id = $request->examen;
        $ordonnace->save();

        $posologies = Posologie::find($posologie->id);
            Session::put('duree', $posologies->duree);
            Session::put('frequence', $posologies->frequence);
            Session::put('dose', $posologies->dose);
        });

        $patients = Resource::where('role', 'patient')->find($request->patient); 
        $medicaments = Medicament::find($request->medicament);

            Session::put('nom', $patients->nom_prenom);
            if($medicaments){
               Session::put('medicament', $medicaments->nom); 
        // Envoyer la notification d'ordonnance
        Mail::to($patients->email)->send(new NewOrdonnanceMail());
            }else{
        Mail::to($patients->email)->send(new AttenteNewOrdonnanceMail()); 
            }
            
        

        return redirect('/listesordonnances')->with('status', 'L\'ordonnance a ete ajouté avec succes.');
    }
    
    public function update_id_ordonnance($id)
    {

        $ordonnancesAll = Ordonnance::with(['medicament', 'posologie', 'resource', 'examen'])->get()->find($id);
        $ordonnances = Ordonnance::find($id);
        $medicaments = Medicament::all();
        $examens = Examen::all();
        $posologies = Posologie::all();
        $patients = Resource::where('role', 'patient')->get();
        $posologiess = Posologie::find($ordonnancesAll->posologie_id);
        return view('ordonnance.updateordonnance',
            compact('ordonnancesAll','ordonnances','medicaments','posologies','patients','posologiess','examens'));
            
    }
    
    public function imprimer($id)
    {

        $ordonnancesAll = Ordonnance::find($id);
        $patients = Resource::where('role', 'patient')->where('id', $ordonnancesAll->patient_id)->first();
        $medecins = Resource::where('role', 'medecin')->where('id', $ordonnancesAll->medecin_id)->first();

        $effectuers = Faire::where('patient_id', $ordonnancesAll->patient_id)->get();
        $examens = Examen::get();
        
        $totalCost = DB::table('examens as e')
            ->join('ordonnances as p', 'e.id', '=', 'p.examen_id')
            ->join('resources as pa', 'p.patient_id', '=', 'pa.id')
            ->where('pa.id', $patients->id)
            ->sum('e.cout');

        $totalMedicament = DB::table('medicaments as e')
            ->join('ordonnances as p', 'e.id', '=', 'p.medicament_id')
            ->join('resources as pa', 'p.patient_id', '=', 'pa.id')
            ->where('pa.id', $patients->id)
            ->sum('e.cout');

        return view('ordonnance.imprimer',
            compact('ordonnancesAll','patients','medecins','effectuers','examens','totalCost','totalMedicament'));
            
    }

    public function update_ordonnance_traitement(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'medicament'=>'nullable',
            'patient' => 'required',
            'examen' => 'required',

            'dose' => 'nullable',
            'frequence' => 'nullable',
            'duree' => 'nullable',
        ]);

        DB::transaction(function () use ($request) {

        $posologie = Posologie::find($request->id);
        $posologie->dose = $request->dose;
        $posologie->frequence = $request->frequence;
        $posologie->duree = $request->duree;
        $posologie->update();

        $ordonnace = Ordonnance::find($request->id);
        $ordonnace->description = $request->description;
        $ordonnace->medicament_id = $request->medicament;
        $ordonnace->posologie_id = $posologie->id;
        $ordonnace->patient_id = $request->patient;
        $ordonnace->medecin_id = session('id');
        $ordonnace->examen_id = $request->examen;
        $ordonnace->update();

        $posologies = Posologie::find($posologie->id);
            Session::put('duree', $posologies->duree);
            Session::put('frequence', $posologies->frequence);
            Session::put('dose', $posologies->dose);
    });  
        
        $patients = Resource::where('role', 'patient')->find($request->patient);
        $medicaments = Medicament::find($request->medicament);

             Session::put('nom', $patients->nom_prenom);
             if($medicaments){
                Session::put('medicament', $medicaments->nom); 
         // Envoyer la notification d'ordonnance
         Mail::to($patients->email)->send(new UpdateOrdonnanceMail());
             }else{
         Mail::to($patients->email)->send(new AttenteNewOrdonnanceMail()); 
             }
        

        return redirect('/listesordonnances');
        
    }

    public function delete_id_ordonnance($id)
    {
        $ordonnance = Ordonnance::find($id);
        $ordonnance->delete();

        return redirect('/listesordonnances')->with('status', 'L\'ordonnance a ete supprimé avec succes.');
    }
    
}