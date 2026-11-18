<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Rendez_vous;
use App\Mail\NewRendezVousMail;
use App\Mail\MedecinNewRendezVousMail;
use App\Mail\UpdateRendezVousMail;
use App\Notifications\AppointmentCreated;
use App\Notifications\AppointmentCreatedMedecin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class RdvController extends Controller
{         
    public function listeRDV()
    {
        $rdvs = Rendez_vous::all();
        
        $patients = Resource::where('role', 'patient')->get();
        $medecins = Resource::whereIn('role', ['admin', 'medecin'])->get();
        return view('ordonnance.listesordonnances', compact('rdvs','patients','medecins'));
    }

    public function calendar()
    {
        $appointments = Rendez_vous::all();
        $patients = Resource::where('role', 'patient')->get();
        $medecins = Resource::whereIn('role', ['admin', 'medecin'])->get();

        return view('planing.calendar', compact('appointments', 'patients', 'medecins'));
    }
    
    public function ajout_RDV(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'heure' => 'required',
            'statut' => 'required',
            'motif' => 'required',
            'patient' => 'required',
        ]);
    
        // Vérifier si l'heure du rendez-vous est déjà prise
        $existingAppointment = Rendez_vous::where('date', $request->date)
            ->where('heure', $request->heure)
            ->first();
    
        if ($existingAppointment) {
            // Si l'heure est déjà prise, retourner une erreur
            return redirect()->back()
                ->withErrors(['heure' => 'Cette heure est déjà prise. Veuillez choisir une autre heure.'])
                ->withInput();
        }
    
        $rdv = new Rendez_vous();
        $rdv->date = $request->date;
        $rdv->heure = $request->heure;
        $rdv->statut = $request->statut;
        $rdv->motif = $request->motif;
        $rdv->patient_id = $request->patient;
        $rdv->medecin_id = session('id');
        $rdv->save();
    
        $patients = Resource::where('role', 'patient')->find($request->patient);
        $patient = Resource::where('email', $patients->email)->first();

        $medecin = Resource::where('email', session('mail'))->first(); 
    
        Session::put('patient', $patients->nom_prenom);
        Session::put('medecin', session('nomuser'));
        Session::put('date', $request->date);
        Session::put('heure', $request->heure);
        Session::put('statut', $request->statut);

        Mail::to($patients->email)->send(new NewRendezVousMail());
        Mail::to(session('mail'))->send(new MedecinNewRendezVousMail());

        // Créer un objet Carbon avec la date et l'heure du rendez-vous

        // Récupérer la date et l'heure depuis le formulaire
        $date1 = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->heure);

        // Définir le fuseau horaire par défaut sur le Cameroun
        date_default_timezone_set('Africa/Douala');

        // Récupérer l'heure actuelle dans le fuseau horaire du Cameroun
        $datee = Carbon::now('Africa/Douala')->format('Y-m-d H:i');
        $date1 = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->heure);
        $date2 = Carbon::createFromFormat('Y-m-d H:i', $datee);

        // Calculer la différence en minutes
        $minutesDiff = intval($date2->diffInMinutes($date1));


        // Soustraire 5 heures à la différence en minutes
        $delaiMinutes = $minutesDiff - (5 * 60);

        $patient1 = session('patient');
        $medecin1 = session('medecin');
        $date1 = session('date');
        $heure1 = session('heure');
        $statut1 = session('statut');

        // Envoi de la notification par email avec un délai de n minutes
        $patient->notify((new AppointmentCreated($patient1,$medecin1,$date1,$heure1,$statut1))->delay(now()->addMinutes($delaiMinutes)));
        $medecin->notify((new AppointmentCreatedMedecin($patient1,$medecin1,$date1,$heure1,$statut1))->delay(now()->addMinutes($delaiMinutes))); 
    
        return redirect('/listesRDV')->with('status', 'Le rendez-vous a été ajouté avec succès.');
    }

    
    public function update_id_RDV($id)
    {
        $rdv = Rendez_vous::find($id);
        
        $patients = Resource::where('role', 'patient')->get();
        return view('RDV.updaterdv', compact('rdv','patients'));
            
    }

    public function update_RDV_traitement(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'heure' => 'required',
            'statut' => 'required',
            'motif' => 'required',
            'patient' => 'required',
        ]);
    
        // Récupérer le rendez-vous à mettre à jour
        $rdv = Rendez_vous::find($request->id);
    
        // Vérifier si l'heure du rendez-vous est déjà prise
        $existingAppointment = Rendez_vous::where('date', $request->date)
            ->where('heure', $request->heure)
            ->where('id', '!=', $request->id)
            ->first();
    
        if ($existingAppointment) {
            // Si l'heure est déjà prise, retourner une erreur
            return redirect()->back()
                ->withErrors(['heure' => 'Cette heure est déjà prise. Veuillez choisir une autre heure.'])
                ->withInput();
        }
    
        // Mettre à jour les informations du rendez-vous
        $rdv->date = $request->date;
        $rdv->heure = $request->heure;
        $rdv->statut = $request->statut;
        $rdv->motif = $request->motif;
        $rdv->patient_id = $request->patient;
        $rdv->medecin_id = session('id');
        $rdv->update();
    
        
        $patients = Resource::where('role', 'patient')->find($request->patient);
        $medecins = Resource::whereIn('role', ['admin', 'medecin'])->find($request->medecin);

            Session::put('patient', $patients->nom_prenom);
            Session::put('medecin', session('nomuser'));
            Session::put('date', $request->date);
            Session::put('heure', $request->heure);
            Session::put('statut', $request->statut);

        
        // Envoyer la notification d'ordonnance
        Mail::to($patients->email)->send(new UpdateRendezVousMail());

        return redirect('/listesRDV');
    }

    public function delete_id_RDV($id)
    {
        $rdv = Rendez_vous::find($id);
        $rdv->delete();

        return redirect('/listesRDV')->with('status', 'Le rendez-vous a ete supprimé avec succes.');
    }
    
}