<?php

namespace App\Http\Controllers;

use App\Models\Motif;
use Illuminate\Http\Request;

class MotifController extends Controller
{
    public function index()
    {
        $motifs = Motif::all();
        return view('motif',compact('motifs'));
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
            'is_accessible_salarie' => 'required|boolean'
        ]);

        $motif = Motif::create($validatedData);

        // Rediriger vers la page d'index avec un message de succès
        return redirect()->route('motif.index')->with('success', 'Motif créé avec succès.');
    }

    public function show(Motif $motif)
    {
        return view('detail_motif', compact('motif'));

    }

    public function edit(Motif $motif)
    {
        $motifs = Motif::all();
        return view('edit_motif',compact('motif'));
    }

    public function update(Request $request, Motif $motif)
    {
        $motif->Libelle = $request->Libelle;
        $motif->is_accessible_salarie = $request->is_accessible_salarie;
        $motif->save();
        return redirect()->route('motif.index');
    }

    public function destroy(Motif $motif)
    {
        $motif->delete();
        return redirect()->route('motif.index');
    }

    public function restore(Motif $motif)
        {
            $motif = Motif::withTrashed()->find($motif);
            if ($motif) {
                $motif->restore();
                return redirect()->route('motif.index')->with('success', 'Motif restauré avec succès.');
            }
            return redirect()->route('motif.index')->with('error', 'Motif non trouvé.');
        }

}
