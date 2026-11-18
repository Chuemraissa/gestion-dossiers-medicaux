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
            'quantite' => 'required|integer|min:0',
            'categorie' => 'required|exists:categories,id',
            'cout' => 'required|numeric|min:0',
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
        $medicaments = Medicament::with('categorie')->findOrFail($id);
        $categories = Categorie::all();
        return view('ordonnance.updatemedicaments', compact('medicaments', 'categories'));
    }

    public function update_medicament_traitement(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'quantite' => 'required|integer|min:0',
            'categorie' => 'required|exists:categories,id',
            'cout' => 'required|numeric|min:0',
        ]);
    
        $medicament = Medicament::findOrFail($request->id);
        $medicament->nom = $request->nom;
        $medicament->quantite = $request->quantite;
        $medicament->categorie_id = $request->categorie;
        $medicament->cout = $request->cout;
        $medicament->update();  

        return redirect('/listemedicaments');
        
    }
    
    public function delete_id_medicament($id)
    {
        $medicament = Medicament::findOrFail($id);
        $medicament->delete();

        return redirect('/listemedicaments');
    }
}