<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbsenceRequest;
use App\Mail\MailDemandeAbsence;
use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Mail;
use Silber\Bouncer\Bouncer;

class AbsenceController extends Controller
{
    /**
     * Summary of index
     *
     * @return View
     */
    public function index()
    {
        if (Auth::user()->isAn('admin')) {
            $absences = Absence::with('user', 'motif')->get();
        }
        elseif (Auth::user()->isAn('salarie')) {
            $absences = Absence::with('motif')->where('user_id', auth()->id())->get();
        }
        else {
            return view('absence');
        }

        return view('absence', compact('absences'));
    }

    /**
     * Summary of create
     *
     * @return View
     */
    public function create()
    {
        $absence = new Absence();
        $motifs = Motif::all();
        $users = User::all();

        return view('absence_form', compact(['motifs', 'users', 'absence']));
    }

    /**
     * Summary of store
     *
     * @return RedirectResponse
     */
    public function store(AbsenceRequest $request)
    {
        $absence = Absence::create([
            'debut' => $request->debut,
            'fin' => $request->fin,
            'motif_id' => $request->motif_id,
            'user_id' => auth()->user()->isAn('salarie') ? auth()->id() : $request->user_id,
        ]);

        $admins = User::whereIs('admin')->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new MailDemandeAbsence($absence,$absence->user,$absence->motif));
        }

        return redirect()->route('absence.index')->with('success', Auth::user()->isAn('salarie') ? "Un mail a été envoyé aux administrateurs lui indiquant votre demande" : "Absence créée avec succès.");
    }

    /**
     * Summary of show
     *
     * @return RedirectResponse|View
     */
    public function show(Absence $absence)
    {
        $absence = Absence::with(['user', 'motif'])->find($absence->id);

        return view('detail_absence', compact('absence'));
    }

    /**
     * Summary of edit
     *
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
     *
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
     * Summary of validateAbsence
     * @return mixed|RedirectResponse
     */
    public function validateAbsence(Absence $absence)
    {
        if (Auth::user()->isAn('salarie')) {
            return redirect()->route('absence.index')->with('error', 'Vous n\'avez pas les droits pour valider cette absence.');
        }
        if ($absence->statut === 0) {
            $absence->statut = 1;
        } else {
            $absence->statut = 0;
        }

        $absence->save();

        return redirect()->route('absence.index');
    }

    /**
     * Summary of destroy
     *
     * @return RedirectResponse
     */
    public function destroy(Absence $absence)
    {
        $absence->delete();

        return redirect()->route('absence.index')->with('success', 'Absence supprimée avec succès');
    }
}
