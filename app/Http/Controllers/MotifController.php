<?php

namespace App\Http\Controllers;

use App\Models\Motif;
use Illuminate\Http\Request;

class MotifController extends Controller
{
    public function index()
    {
        $motifs = Motif::all();
        return view('motif', compact('motifs'));
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
        return view('detail_motif',compact('motif'));
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
