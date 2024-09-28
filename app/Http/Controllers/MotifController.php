<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\MotifRequest;
use App\Models\Motif;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MotifController extends Controller
{
    /**
     * Summary of index
     *
     * @return View
     */
    public function index()
    {
        $motifs = Motif::all();

        return view('motif', compact('motifs'));
    }

    /**
     * Summary of create
     *
     * @return View|RedirectResponse
     */
    public function create()
    {
        $motif = new Motif();

        return view('motif_form', compact('motif'));
    }

    /**
     * Summary of store
     *
     * @return RedirectResponse
     */
    public function store(MotifRequest $request)
    {
        $validatedData = $request->validate([
            'Libelle' => 'required|string|max:255',
        ]);

        $motif = Motif::create($validatedData);

        return redirect()->route('motif.index')->with('success', __('Reason created successfully.'));
    }

    /**
     * Summary of show
     *
     * @return View
     */
    public function show(Motif $motif)
    {
        return view('detail_motif', compact('motif'));
    }

    /**
     * Summary of edit
     *
     * @return View
     */
    public function edit(Motif $motif)
    {
        $motifs = Motif::all();

        return view('motif_form', compact('motif'));
    }

    /**
     * Summary of update
     *
     * @return mixed|RedirectResponse
     */
    public function update(MotifRequest $request, Motif $motif)
    {
        $motif->Libelle = $request->Libelle;
        $motif->save();

        return redirect()->route('motif.index')->with('success',__('Reason modified successfully'));
    }

    /**
     * Summary of destroy
     *
     * @return mixed|RedirectResponse
     */
    public function destroy(Motif $motif)
    {
        $motif->delete();

        return redirect()->route('motif.index')->with('success',__('Reason deleted successfully'));
    }
}
