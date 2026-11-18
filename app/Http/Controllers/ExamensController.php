<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examen;

class ExamensController extends Controller
{
    public function listeexamens()
    {
        $examens = Examen::all();
        return view('ordonnance.listesordonnances', compact('examens'));
    }

    public function ajout_examen(Request $request)
    {
        $request->validate([
            'type_examen' => 'required',
            'description_examen' => 'required',
            'cout' => 'required',
        ]);
    
            $Examen = new Examen();
            $Examen->type = $request->type_examen;
            $Examen->description = $request->description_examen;
            $Examen->cout = $request->cout;
            $Examen->save();
    
        return redirect('/listesexamens')->with('status', 'L\'utilisateur, les paramètres et les antécédents ont été ajoutés avec succès.');
    }
    
    public function update_id_examen($id)
    {
        $examens = Examen::find($id);
        return view('examen.updateexamens', compact('examens'));
    }

    public function update_examen_traitement(Request $request)
    {
        $request->validate([
            'type_examen' => 'required',
            'description_examen' => 'required',
            'cout' => 'required',
        ]);
    
            $Examen = Examen::find($request->id);
            $Examen->type = $request->type_examen;
            $Examen->description = $request->description_examen;
            $Examen->cout = $request->cout;
            $Examen->update();  

        return redirect('/listesexamens')->with('status', 'L\'utilisateur a ete modifié avec succes.');
        
    }
    
    public function delete_id_examen($id)
    {
        $examen = Examen::find($id);
        $examen->delete();

        return redirect('/listesexamens')->with('status', 'L\'utilisateur a ete supprimé avec succes.');
    }
}
