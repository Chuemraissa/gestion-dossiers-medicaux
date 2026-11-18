<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

class CategoriesController extends Controller
{
    public function listecategories()
    {
        $categories = Categorie::all();
        return view('ordonnance.listestraitements', compact('categories'));
    }

    public function ajout_categorie(Request $request)
    {
        $request->validate([
            'nom' => 'required',
        ]);

        $resources = new Categorie();
        $resources->nom = $request->nom;
        $resources->save();

        return redirect('/listecategories');
    }
    
    public function update_id_categorie($id)
    {
        $categories = Categorie::find($id);
        return view('ordonnance.updatecategories', compact('categories'));
    }

    public function update_categorie_traitement(Request $request)
    {
        $request->validate([
            'nom' => 'required',
        ]);

        $categorie = Categorie::find($request->id);
        $categorie->nom = $request->nom;
        $categorie->update();  

        return redirect('/listecategories');
        
    }

    public function delete_id_categorie($id)
    {
        $categorie = Categorie::find($id);
        $categorie->delete();

        return redirect('/listecategories');
    }

}