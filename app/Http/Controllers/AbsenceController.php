<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        return view('absence.index');
    }

    public function create()
    {
        return view('absence.create');

    }

    public function store(Request $request)
    {
        //
    }

    public function show(Absence $absence,$a)
    {
        $list = Absence::where('id','=',$a)->get();
        dd($list);
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
