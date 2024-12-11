<?php

namespace App\Http\Controllers;

use App\Http\Requests\JoursSensiblesRequest;
use App\Models\Equipe;
use App\Models\JoursSensibles;
use Auth;
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
        $sensible = new JoursSensibles;
        $equipe = Equipe::all();
        return view('joursSensibles.create', compact('sensible','equipe'));

    }

    public function store(JoursSensiblesRequest $request)
    {
        if (Auth::user()->isAn('rh')) {
            $sensible = new JoursSensibles;
            $sensible->debut = $request->debut;
            $sensible->fin = $request->fin;
            $sensible->equipe_id = $request->equipe;
            $sensible->save();
            return redirect()->route('joursSensibles.index')->with('success', __('Sensible Period added with success.'));
        } else {
            return redirect()->route('accueil')->with('error', 'You don\'t have the permission to add a sensible period.');
        }

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
