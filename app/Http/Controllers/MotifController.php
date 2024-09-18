<?php

namespace App\Http\Controllers;

use App\Models\Motif;
use Illuminate\Http\Request;

class MotifController extends Controller
{
    public function index()
    {
        $liste = Motif::all();
        dd($liste);
    }

    public function create()
    {
        return view('add_motif');
    }

    public function store(Request $request)
    {
        // Valider les données de la requête
        $validatedData = $request->validate([
            'Libelle' => 'required|string|max:255',
        ]);

        // Créer et enregistrer le nouveau motif
        $motif = Motif::create($validatedData);

        // Rediriger vers la page d'index avec un message de succès
        return redirect()->route('motif.index')->with('success', 'Motif créé avec succès.');
    }

    public function show(Motif $motif)
    {
<<<<<<< Updated upstream
        //
=======
        return view('detail_motif', compact('motif'));
>>>>>>> Stashed changes
    }

    public function edit(Motif $motif)
    {
        $motifs = Motif::all();
        return view('edit_motif',compact('motif'));
    }

    public function update(Request $request, Motif $motif)
    {
        $validate = $request->validate([
            'Libelle' => 'required|string|max:255'
        ]);
        $motif->update($validate);
        return redirect()->route('motif.index')->with('success','Motif modifié avec succès.');
    }

    public function destroy(Motif $motif)
    {
        $motif->delete();
        return redirect()->route('motif.index')->with('success','Motif supprimé avec succès');
    }
}
