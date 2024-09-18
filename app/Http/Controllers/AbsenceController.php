<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = Absence::with('user')->with('motif')->get();
        return view('absence',compact('absences'));
    }

    public function create()
    {
        return view('absence.create');

    }

    public function store(Request $request)
    {
        //
    }

    public function show(Absence $absence)
    {
        return view('detail_absence',compact('absence'));
    }

    public function edit(Absence $absence)
    {
        //
    }

    public function update(Request $request, Absence $absence)
    {
        //
    }

    public function destroy(Absence $absence)
    {
        //
    }
}
