<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\AbsenceRequest;
use App\Mail\MailDemandeAbsence;
use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Policies\AbsencePolicy;
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
     * @return View | RedirectResponse
     */
    public function create()
    {
        if (Auth::user()->can('create-absences')) {
            $absence = new Absence();
            $motifs = Motif::all();
            $users = User::all();

            return view('absence_form', compact(['motifs', 'users', 'absence']));
        } else {
            return redirect()->route('absence.index')->with('error',__("You don't have the permission to add an absence."));
        }

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

        return redirect()->route('absence.index')->with('success', Auth::user()->isAn('salarie') ? __('An email has been sent to the administrators indicating your request') : __('Absence created successfully.'));
    }

    /**
     * Summary of show
     *
     * @return RedirectResponse|View
     */
    public function show(Absence $absence)
    {
        $absence = Absence::with(['user', 'motif'])->find($absence->id);

        if (Auth::user()->isAn('admin') | (Auth::user()->can('view-absences') && Auth::id() === $absence->user_id)) {
            return view('detail_absence', compact('absence'));
        } else {
            return redirect()->route('absence.index')->with('error', __("You don't have the permission to access this absence."));
        }
    }

    /**
     * Summary of edit
     *
     * @return View | RedirectResponse
     */
    public function edit(Absence $absence)
    {
        if (Auth::user()->isAn('admin') | (Auth::user()->can('edit-absences') && Auth::id() === $absence->user_id)) {
            $absences = Absence::all();
            $motifs = Motif::all();
            $users = User::all();

            return view('absence_form', compact(['motifs', 'users', 'absence']));
        } else {
            return redirect()->route('absence.index')->with('error',__("You don't have the permission to edit this absence."));
        }
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

        return redirect()->route('absence.index')->with('success', __('Absence modified successfully'));
    }

    /**
     * Summary of validateAbsence
     * @return mixed|RedirectResponse
     */
    public function validateAbsence(Absence $absence)
    {
        if ($absence->statut === 0) {
            $absence->statut = 1;
        } else {
            $absence->statut = 0;
        }

        $absence->save();

        return redirect()->route('absence.index')->with('success',__('Absence validated successfully'));
    }

    /**
     * Summary of destroy
     *
     * @return RedirectResponse
     */
    public function destroy(Absence $absence)
    {
        $absence->delete();

        return redirect()->route('absence.index')->with('success', __('Absence deleted successfully'));
    }
}
