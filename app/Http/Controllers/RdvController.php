<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Resource;
use App\Models\Rendez_vous;
use App\Mail\NewRendezVousMail;
use App\Mail\MedecinNewRendezVousMail;
use App\Mail\UpdateRendezVousMail;
use App\Notifications\AppointmentCreated;
use App\Notifications\AppointmentCreatedMedecin;

class RdvController extends Controller
{
    /**
     * Nombre d'heures avant le rendez-vous où le rappel est envoyé.
     */
    private const HEURES_AVANT_RAPPEL = 5;

    public function listeRDV()
    {
        $rdvs = Rendez_vous::all();
        $patients = Resource::patients()->get();
        $medecins = Resource::medecins()->get();

        return view('ordonnance.listesordonnances', compact('rdvs', 'patients', 'medecins'));
    }

    public function calendar()
    {
        $appointments = Rendez_vous::all();
        $patients = Resource::patients()->get();
        $medecins = Resource::medecins()->get();

        return view('planing.calendar', compact('appointments', 'patients', 'medecins'));
    }

    public function ajout_RDV(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'heure' => 'required',
            'statut' => 'required',
            'motif' => 'required',
            'patient' => 'required|exists:resources,id',
        ]);

        if ($this->heureDejaPrise($request->date, $request->heure)) {
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
        $rdv->medecin_id = auth()->id();
        $rdv->save();

        $patient = Resource::findOrFail($request->patient);
        $medecin = auth()->user();

        $this->preparerDonneesMail($patient, $request);
        $this->envoyerMail($patient->email, new NewRendezVousMail());
        $this->envoyerMail($medecin->email, new MedecinNewRendezVousMail());

        $this->programmerRappels($patient, $medecin, $request);

        return redirect('/listesRDV')->with('status', 'Le rendez-vous a été ajouté avec succès.');
    }

    public function update_id_RDV($id)
    {
        $rdv = Rendez_vous::findOrFail($id);
        $patients = Resource::patients()->get();

        return view('RDV.updaterdv', compact('rdv', 'patients'));
    }

    public function update_RDV_traitement(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:rendez_vouses,id',
            'date' => 'required|date',
            'heure' => 'required',
            'statut' => 'required',
            'motif' => 'required',
            'patient' => 'required|exists:resources,id',
        ]);

        $rdv = Rendez_vous::findOrFail($request->id);

        if ($this->heureDejaPrise($request->date, $request->heure, $rdv->id)) {
            return redirect()->back()
                ->withErrors(['heure' => 'Cette heure est déjà prise. Veuillez choisir une autre heure.'])
                ->withInput();
        }

        $rdv->date = $request->date;
        $rdv->heure = $request->heure;
        $rdv->statut = $request->statut;
        $rdv->motif = $request->motif;
        $rdv->patient_id = $request->patient;
        $rdv->medecin_id = auth()->id();
        $rdv->save();

        $patient = Resource::findOrFail($request->patient);
        $this->preparerDonneesMail($patient, $request);
        $this->envoyerMail($patient->email, new UpdateRendezVousMail());

        return redirect('/listesRDV')->with('status', 'Le rendez-vous a été modifié avec succès.');
    }

    public function delete_id_RDV($id)
    {
        $rdv = Rendez_vous::findOrFail($id);
        $rdv->delete();

        return redirect('/listesRDV')->with('status', 'Le rendez-vous a été supprimé avec succès.');
    }

    private function heureDejaPrise(string $date, string $heure, ?int $saufId = null): bool
    {
        return Rendez_vous::where('date', $date)
            ->where('heure', $heure)
            ->when($saufId, fn ($query) => $query->where('id', '!=', $saufId))
            ->exists();
    }

    /**
     * Données lues par les modèles d'e-mail des rendez-vous.
     */
    private function preparerDonneesMail(Resource $patient, Request $request): void
    {
        Session::put('patient', $patient->nom_prenom);
        Session::put('medecin', auth()->user()->nom_prenom);
        Session::put('date', $request->date);
        Session::put('heure', $request->heure);
        Session::put('statut', $request->statut);
    }

    /**
     * Programme l'e-mail de rappel quelques heures avant le rendez-vous.
     * Les rappels sont mis en file d'attente : ils partent seulement si la commande
     * « php artisan queue:work » tourne (voir README).
     */
    private function programmerRappels(Resource $patient, Resource $medecin, Request $request): void
    {
        try {
            $dateRdv = Carbon::parse($request->date.' '.$request->heure, config('app.timezone'));
            $dateRappel = $dateRdv->copy()->subHours(self::HEURES_AVANT_RAPPEL);
            // Si le rendez-vous est très proche, le rappel part tout de suite
            $envoi = $dateRappel->isFuture() ? $dateRappel : now();

            $infos = [$patient->nom_prenom, $medecin->nom_prenom, $request->date, $request->heure, $request->statut];

            $patient->notify((new AppointmentCreated(...$infos))->delay($envoi));
            $medecin->notify((new AppointmentCreatedMedecin(...$infos))->delay($envoi));
        } catch (\Throwable $e) {
            Log::warning('Rappel de rendez-vous non programmé : '.$e->getMessage());
        }
    }
}
