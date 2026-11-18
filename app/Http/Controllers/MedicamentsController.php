<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicament;
use App\Models\Categorie;

class MedicamentsController extends Controller
{
    public function listemedicaments()
    {
        $medicaments = Medicament::with('categorie')->get();
        $categories = Categorie::all();
        return view('ordonnance.listestraitements', compact('medicaments', 'categories'));
    }

    public function ajout_medicament(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'quantite' => 'required',
            'categorie' => 'required',
            'cout' => 'required',
        ]);
    
            $medicament = new Medicament();
            $medicament->nom = $request->nom;
            $medicament->quantite = $request->quantite;
            $medicament->categorie_id = $request->categorie;
            $medicament->cout = $request->cout;
            $medicament->save();
    
        return redirect('/listemedicaments');
    }
    
    public function update_id_medicament($id)
    {
        $medicaments = Medicament::with('categorie')->get()->find($id);
        $categories = Categorie::all();
        return view('ordonnance.updatemedicaments', compact('medicaments', 'categories'));
    }

    public function update_medicament_traitement(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'quantite' => 'required',
            'categorie' => 'required',
            'cout' => 'required',
        ]);
    
        $medicament = Medicament::find($request->id);
        $medicament->nom = $request->nom;
        $medicament->quantite = $request->quantite;
        $medicament->categorie_id = $request->categorie;
        $medicament->cout = $request->cout;
        $medicament->update();  

        return redirect('/listemedicaments');
        
    }
    
    public function delete_id_medicament($id)
    {
        $medicament = Medicament::find($id);
        $medicament->delete();

        return redirect('/listemedicaments');
    }
}