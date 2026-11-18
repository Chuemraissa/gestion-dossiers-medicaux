<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posologie;

class PosologiesController extends Controller
{
    public function listeposologies()
    {
        $posologies = Posologie::all();
        return view('ordonnance.listestraitements', compact('posologies'));
    }

    public function delete_id_posologie($id)
    {
        $Posologie = Posologie::find($id);
        $Posologie->delete();

        return redirect('/listeposologies')->with('status', 'L\'utilisateur a ete supprimé avec succes.');
    }

}