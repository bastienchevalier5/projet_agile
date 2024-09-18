<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Absence;
use App\Models\Motif;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = Absence::all();
        return view('absence',compact('absences'));
    }

    public function create()
    {
        $motifs = Motif::all();
        $users = User::all();
        return view('add_absence',compact(['motifs','users']));

    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'debut' => 'required|date',
            'fin' => 'required|date',
            'motif_id' => 'required|exists:motifs,id',
            'user_id' => 'required|exists:users,id'
        ]);
        $absence = Absence::create($validate);
        return redirect()->route('absence.index')->with('success','Absence créée avec succès');

    }

    public function show(Absence $absence)
    {
        $absence = Absence::with(['user', 'motif'])->find($absence->id);

        return view('detail_absence', compact('absence'));
    }


    public function edit(Absence $absence)
    {
        $absences = Absence::all();
        $motifs = Motif::all();
        $users = User::all();
        return view('edit_absence',compact(['motifs','users','absence']));
    }

    public function update(Request $request, Absence $absence)
    {
        $validate = $request->validate([
            'debut' => 'required|date',
            'fin' => 'required|date',
            'motif_id' => 'required|exists:motifs,id',
            'user_id' => 'required|exists:users,id'
        ]);
        $absence->update($validate);
        return redirect()->route('absence.index')->with('success','Absence modifiée avec succès');
    }

    public function destroy(Absence $absence)
    {
        $absence->delete();
        return redirect()->route('absence.index')->with('success','Absence supprimée avec succès');
    }
}
