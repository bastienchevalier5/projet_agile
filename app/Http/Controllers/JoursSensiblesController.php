<?php

namespace App\Http\Controllers;

use App\Models\JoursSensibles;
use Illuminate\Http\Request;

class JoursSensiblesController extends Controller
{
    public function index()
    {
        $sensibles = JoursSensibles::all();
        return view('joursSensibles.index', compact('sensibles'));
    }

    public function create()
    {
        return view('joursSensibles.create');

    }

    public function store(Request $request)
    {
        //
    }

    public function show(JoursSensibles $joursSensibles)
    {
        //
    }

    public function edit(JoursSensibles $joursSensibles)
    {
        //
    }

    public function update(Request $request, JoursSensibles $joursSensibles)
    {
        //
    }

    public function destroy(JoursSensibles $joursSensibles)
    {
        //
    }
}
