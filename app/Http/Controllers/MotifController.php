<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\MotifRequest;
use App\Models\Motif;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
class MotifController extends Controller
{
    /**
     * Summary of index
     * @return View
     */
    public function index()
    {
        $motifs = Motif::all();

        return view('motif', compact('motifs'));
    }

    /**
     * Summary of create
     * @return View|RedirectResponse
     */
    public function create()
    {
        $motif = new Motif;
        return view('motif_form',compact('motif'));

    }

    /**
     * Summary of store
     * @return RedirectResponse
     */
    public function store(MotifRequest $request)
    {
        // Valider les données de la requête
        $validatedData = $request->validate([
            'Libelle' => 'required|string|max:255',
            'is_accessible_salarie' => 'required|boolean',
        ]);

        $motif = Motif::create($validatedData);

        // Rediriger vers la page d'index avec un message de succès
        return redirect()->route('motif.index')->with('success', 'Motif créé avec succès.');
    }

    /**
     * Summary of show
     * @return View
     */
    public function show(Motif $motif)
    {
        return view('detail_motif', compact('motif'));
    }

    /**
     * Summary of edit
     * @return View
     */
    public function edit(Motif $motif)
    {
        $motifs = Motif::all();

        return view('motif_form', compact('motif'));
    }

    /**
     * Summary of update
     * @return mixed|RedirectResponse
     */
    public function update(MotifRequest $request, Motif $motif)
    {
        $motif->Libelle = $request->Libelle;
        $motif->is_accessible_salarie = $request->is_accessible_salarie;
        $motif->save();

        return redirect()->route('motif.index');
    }

    /**
     * Summary of destroy
     * @return mixed|RedirectResponse
     */
    public function destroy(Motif $motif)
    {
        $motif->delete();

        return redirect()->route('motif.index');
    }

    /**
     * Summary of restore
     * @return RedirectResponse
     */
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
