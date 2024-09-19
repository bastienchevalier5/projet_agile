<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbsenceRequest;
use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
class AbsenceController extends Controller
{
    /**
     * Summary of index
     * @return View
     */
    public function index()
    {
        $absences = Absence::all();

        return view('absence', compact('absences'));
    }

    /**
     * Summary of create
     * @return View
     */
    public function create()
    {
        $absence = new Absence;
        $motifs = Motif::all();
        $users = User::all();

        return view('absence_form', compact(['motifs', 'users','absence']));
    }

    /**
     * Summary of store
     * @return RedirectResponse
     */
    public function store(AbsenceRequest $request)
    {
        $validate = $request->validate([
            'debut' => 'required|date',
            'fin' => 'required|date',
            'motif_id' => 'required|exists:motifs,id',
            'user_id' => 'required|exists:users,id',
        ]);
        $absence = Absence::create($validate);

        return redirect()->route('absence.index')->with('success', 'Absence créée avec succès');
    }

    /**
     * Summary of show
     * @return RedirectResponse|View
     */
    public function show(Absence $absence)
    {


        $absence = Absence::with(['user', 'motif'])->find($absence->id);

        return view('detail_absence', compact('absence'));
    }

    /**
     * Summary of edit
     * @return View
     */
    public function edit(Absence $absence)
    {
        $absences = Absence::all();
        $motifs = Motif::all();
        $users = User::all();

        return view('absence_form', compact(['motifs', 'users', 'absence']));
    }

    /**
     * Summary of update
     * @return RedirectResponse
     */
    public function update(AbsenceRequest $request, Absence $absence)
    {
        $validate = $request->validate([
            'debut' => 'required|date',
            'fin' => 'required|date',
            'motif_id' => 'required|exists:motifs,id',
            'user_id' => 'required|exists:users,id',
        ]);
        $absence->update($validate);

        return redirect()->route('absence.index')->with('success', 'Absence modifiée avec succès');
    }

    /**
     * Summary of destroy
     * @return RedirectResponse
     */
    public function destroy(Absence $absence)
    {
        $absence->delete();

        return redirect()->route('absence.index')->with('success', 'Absence supprimée avec succès');
    }
}
