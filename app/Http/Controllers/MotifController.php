<?php

namespace App\Http\Controllers;

use App\Models\Motif;
use Illuminate\Http\Request;

class MotifController extends Controller
{
    public function index()
    {
        $liste = Motif::all();
        dd($liste);
    }

    public function create()
    {
        return view('motif.create');

    }

    public function store(Request $request)
    {
        //
    }

    public function show(Motif $motif)
    {
        //
    }

    public function edit(Motif $motif)
    {
        //
    }

    public function update(Request $request, Motif $motif)
    {
        //
    }

    public function destroy(Motif $motif)
    {
        //
    }
}
