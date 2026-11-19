<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Ordonnance;
use App\Models\Medicament;
use App\Models\Posologie;
use App\Models\Resource;
use App\Models\Faire;
use App\Models\Examen;
use App\Mail\NewOrdonnanceMail;
use App\Mail\AttenteNewOrdonnanceMail;
use App\Mail\UpdateOrdonnanceMail;

class OrdonnancesController extends Controller
{
    public function listeordonnances()
    {
        $ordonnancesAll = Ordonnance::with(['medicament', 'posologie', 'patient', 'examen'])->get();
        $medicaments = Medicament::all();
        $examens = Examen::all();
        $posologies = Posologie::all();
        $patients = Resource::patients()->get();
        $medecins = Resource::medecins()->get();

        return view('ordonnance.listesordonnances',
            compact('ordonnancesAll', 'medicaments', 'posologies', 'patients', 'medecins', 'examens'));
    }

    public function certificat($id)
    {
        $ordonnance = Ordonnance::findOrFail($id);
        $patient = Resource::findOrFail($ordonnance->patient_id);
        // Le certificat est signé par le médecin qui a rédigé l'ordonnance
        $medecin = Resource::find($ordonnance->medecin_id);

        return view('ordonnance.certificat', compact('patient', 'medecin'));
    }

    public function ajout_ordonnance(Request $request)
    {
        $request->validate([
            'description' => 'required',
            // Le médicament peut être choisi plus tard (ex. après les résultats d'examen)
            'medicament' => 'nullable|exists:medicaments,id',
            'patient' => 'required|exists:resources,id',
            'examen' => 'required|exists:examens,id',
            'dose' => 'nullable',
            'frequence' => 'nullable',
            'duree' => 'nullable',
        ]);

        DB::transaction(function () use ($request) {
            $posologie = Posologie::create([
                'dose' => $request->dose,
                'frequence' => $request->frequence,
                'duree' => $request->duree,
            ]);

            Ordonnance::create([
                'description' => $request->description,
                'medicament_id' => $request->medicament,
                'posologie_id' => $posologie->id,
                'patient_id' => $request->patient,
                'medecin_id' => auth()->id(),
                'examen_id' => $request->examen,
            ]);
        });

        $this->notifierPatient($request, new NewOrdonnanceMail());

        return redirect('/listesordonnances')->with('status', __('L\'ordonnance a été ajoutée avec succès.'));
    }

    public function update_id_ordonnance($id)
    {
        $ordonnancesAll = Ordonnance::with(['medicament', 'posologie', 'patient', 'examen'])->findOrFail($id);
        $ordonnances = $ordonnancesAll;
        $medicaments = Medicament::all();
        $examens = Examen::all();
        $posologies = Posologie::all();
        $patients = Resource::patients()->get();
        $posologiess = $ordonnancesAll->posologie;

        return view('ordonnance.updateordonnance',
            compact('ordonnancesAll', 'ordonnances', 'medicaments', 'posologies', 'patients', 'posologiess', 'examens'));
    }

    public function imprimer($id)
    {
        $ordonnancesAll = Ordonnance::with(['medicament', 'posologie', 'examen'])->findOrFail($id);
        $patients = Resource::findOrFail($ordonnancesAll->patient_id);
        $medecins = Resource::find($ordonnancesAll->medecin_id);

        $effectuers = Faire::where('patient_id', $patients->id)->get();
        $examens = Examen::get();

        $totalCost = DB::table('examens as e')
            ->join('ordonnances as p', 'e.id', '=', 'p.examen_id')
            ->where('p.patient_id', $patients->id)
            ->sum('e.cout');

        $totalMedicament = DB::table('medicaments as e')
            ->join('ordonnances as p', 'e.id', '=', 'p.medicament_id')
            ->where('p.patient_id', $patients->id)
            ->sum('e.cout');

        return view('ordonnance.imprimer',
            compact('ordonnancesAll', 'patients', 'medecins', 'effectuers', 'examens', 'totalCost', 'totalMedicament'));
    }

    public function update_ordonnance_traitement(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:ordonnances,id',
            'description' => 'required',
            'medicament' => 'nullable|exists:medicaments,id',
            'patient' => 'required|exists:resources,id',
            'examen' => 'required|exists:examens,id',
            'dose' => 'nullable',
            'frequence' => 'nullable',
            'duree' => 'nullable',
        ]);

        DB::transaction(function () use ($request) {
            $ordonnance = Ordonnance::findOrFail($request->id);

            // On modifie la posologie liée à CETTE ordonnance (et non celle qui aurait le même numéro)
            $posologie = Posologie::find($ordonnance->posologie_id) ?? new Posologie();
            $posologie->dose = $request->dose;
            $posologie->frequence = $request->frequence;
            $posologie->duree = $request->duree;
            $posologie->save();

            $ordonnance->description = $request->description;
            $ordonnance->medicament_id = $request->medicament;
            $ordonnance->posologie_id = $posologie->id;
            $ordonnance->patient_id = $request->patient;
            $ordonnance->medecin_id = auth()->id();
            $ordonnance->examen_id = $request->examen;
            $ordonnance->save();
        });

        $this->notifierPatient($request, new UpdateOrdonnanceMail());

        return redirect('/listesordonnances')->with('status', __('L\'ordonnance a été modifiée avec succès.'));
    }

    public function delete_id_ordonnance($id)
    {
        $ordonnance = Ordonnance::findOrFail($id);
        $posologieId = $ordonnance->posologie_id;
        $ordonnance->delete();

        // La posologie n'appartient qu'à cette ordonnance : on la supprime aussi
        Posologie::whereKey($posologieId)->delete();

        return redirect('/listesordonnances')->with('status', __('L\'ordonnance a été supprimée avec succès.'));
    }

    /**
     * Prévient le patient par e-mail. Sans médicament, il reçoit le message « en attente ».
     */
    private function notifierPatient(Request $request, $mailAvecMedicament): void
    {
        $patient = Resource::find($request->patient);
        $medicament = Medicament::find($request->medicament);

        // Données lues par les modèles d'e-mail
        Session::put('nom', $patient?->nom_prenom);
        Session::put('dose', $request->dose);
        Session::put('frequence', $request->frequence);
        Session::put('duree', $request->duree);

        if ($medicament) {
            Session::put('medicament', $medicament->nom);
            $this->envoyerMail($patient?->email, $mailAvecMedicament);
        } else {
            $this->envoyerMail($patient?->email, new AttenteNewOrdonnanceMail());
        }
    }
}
