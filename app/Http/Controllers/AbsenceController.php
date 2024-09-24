<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbsenceRequest;
use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Auth;
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
        if (Auth::user()->isAn('admin')) {
            $absences = Absence::with('user', 'motif')->get();
        }
        // Si l'utilisateur est un salarié, récupérer uniquement ses absences
        elseif (Auth::user()->isAn('salarie')) {
            $absences = Absence::with('motif')->where('user_id', auth()->id())->get();
        }

        // Passer les absences à la vue
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
        // Créer l'absence avec les données validées, et attribuer l'user_id en fonction du rôle
        $absence = Absence::create([
            'debut' => $request->debut,
            'fin' => $request->fin,
            'motif_id' => $request->motif_id,
            'user_id' => auth()->user()->isAn('salarie') ? auth()->id() : $request->user_id,
        ]);

        return redirect()->route('absence.index')->with('success', 'Absence créée avec succès.');
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

    public function validateAbsence(Absence $absence)
    {
        if (Auth::user()->isAn('salarie')) {
            return redirect()->route('absence.index')->with('error', 'Vous n\'avez pas les droits pour valider cette absence.');
        }
        if ($absence->statut == false){
            $absence->statut = true;
        } else {
            $absence->statut = false;
        }

        $absence->save();

        return redirect()->route('absence.index');
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
