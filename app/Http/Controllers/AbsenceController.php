<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AbsenceRepository;
use App\Http\Requests\AbsenceRequest;
use App\Mail\MailAbsenceRefusee;
use App\Mail\MailAbsenceValidee;
use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Mail;

class AbsenceController extends Controller
{
    private AbsenceRepository $repository;

    public function __construct(AbsenceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->isAn('rh')) {
            $absences = Absence::all();
        } else {
            $absences = Absence::all()->where('user_id', $user->id);
        }

        return view('lists', compact('absences'));
    }

    public function create(): View|RedirectResponse
    {
        $user = Auth::user();

        // Vérification de l'authentification
        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->can('create-absences')) {
            $absence = new Absence();
            $motifs = Motif::all();
            $users = User::all();

            return view('absence_form', compact(['motifs', 'users', 'absence']));
        }

        return redirect()->route('absence.index')->with('error', __("You don't have the permission to add an absence."));
    }

    public function store(AbsenceRequest $request): RedirectResponse
    {
        $user = Auth::user();

        // Vérification de l'authentification
        if (! $user) {
            return redirect()->route('login');
        }

        $absence = $this->repository->store($request->validated(), $user);
        $this->repository->notifyrhs($absence);

        return redirect()->route('absence.index')->with('success', $user->isAn('salarie') ? __('An email has been sent to the rhistrators indicating your request') : __('Absence created successfully.'));
    }

    public function show(Absence $absence): RedirectResponse|View
    {
        $absence->load(['user', 'motif']); // Chargement des relations
        $user = Auth::user();

        // Vérification de l'authentification
        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->isAn('rh') || ($user->can('view-absences') && $user->id === $absence->user_id)) {
            return view('detail_absence', compact('absence'));
        }

        return redirect()->route('absence.index')->with('error', __("You don't have the permission to access this absence."));
    }

    public function edit(Absence $absence): View|RedirectResponse
    {
        $user = Auth::user();

        // Vérification de l'authentification
        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->isAn('rh') || ($user->can('edit-absences') && $user->id === $absence->user_id)) {
            $motifs = Motif::all();
            $users = User::all();

            return view('absence_form', compact(['motifs', 'users', 'absence']));
        }

        return redirect()->route('absence.index')->with('error', __("You don't have the permission to edit this absence."));
    }

    public function update(AbsenceRequest $request, Absence $absence): RedirectResponse
    {
        $user = Auth::user();

        // Vérification de l'authentification
        if (! $user) {
            return redirect()->route('login');
        }

        $this->repository->update($absence, $request->validated(), $user);

        return redirect()->route('absence.index')->with('success', __('Absence modified successfully.'));
    }

    public function validateAbsence(Absence $absence): RedirectResponse
    {
        $user = Auth::user();

        // Vérification de l'authentification
        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->isAn('rh')) {
            $absence->statut = $absence->statut === 0 ? 1 : 0;
            $absence->save();
            if ($absence->statut === 1) {
                $absenceUser = $absence->user;
                $absenceMotif = $absence->motif;
                Mail::to($absenceUser->email)->send(new MailAbsenceValidee($absence,$user,$absenceMotif));
            }
            return redirect()->route('absence.index')->with('success', __('Absence ' . ($absence->statut === 0 ? 'removed' : 'validated') . ' successfully.'));
        }

        return redirect()->route('absence.index')->with('error', "You don't have the permission to validate this absence.");
    }

    public function destroy(Absence $absence): RedirectResponse
    {
        $user = Auth::user();

        // Vérification de l'authentification
        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->isAn('rh')) {
            $absence->delete();
            $absenceUser = $absence->user;
            $absenceMotif = $absence->motif;
            Mail::to($absenceUser->email)->send(new MailAbsenceRefusee($absence,$user,$absenceMotif));
            return redirect()->route('absence.index')->with('success', __('An email has been sent to the user indicating your refusal.'));
        }

        return redirect()->route('absence.index')->with('error', __("You don't have the permission to refuse this absence."));
    }
    public function userPlanning(User $user): View|RedirectResponse
    {
        $user = Auth::user();

        // Vérification de l'authentification
        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->isAn('admin') || $user->id === $user->id) {
            $events = Auth::user()->absences;
            $calendarEvents = [];

            foreach ($events as $event) {
                $event->statut === 1 ? $color = '#28a745' : $color = '#dc3545'; // Couleur de l'événement

                $calendarEvents[] = [
                    'title' => $event->motif->Libelle,
                    'start' => $event->debut,
                    'end' => $event->fin,
                    'backgroundColor'=> $color,
                ];
            }
            // dd($calendarEvents);
            return view('absence.planning', compact('calendarEvents'));
        }

        return redirect()->route('absence.index')->with('error', __("You don't have the permission to access this planning."));
    }
    public function allPlanning(): View|RedirectResponse
    {
        $user = Auth::user();

        // Vérification de l'authentification
        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->isAn('responsable')) {
            $events = Absence::all();
            $calendarEvents = [];

            foreach ($events as $event) {
                $event->statut === 1 ? $color = '#28a745' : $color = '#dc3545'; // Couleur de l'événement
                $title = $event->user->name . ' - ' . $event->motif->Libelle;
                $calendarEvents[] = [
                    'title' => $title,
                    'start' => $event->debut,
                    'end' => $event->fin,
                    'backgroundColor'=> $color,
                ];
            }
            // dd($calendarEvents);
            return view('absence.allPlanning', compact('calendarEvents'));
        }

        return redirect()->route('absence.index')->with('error', __("You don't have the permission to access this planning."));
    }
}
