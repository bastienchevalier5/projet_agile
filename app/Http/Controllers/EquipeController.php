<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
    public function index()
    {
        return view('equipe.index');
    }

    public function create()
    {
        return view('equipe.create');

    }

    public function store(Request $request)
    {
        //
    }

    public function show(Equipe $equipe)
    {
        //
    }

    public function edit(Equipe $equipe)
    {
        //
    }

    public function update(Request $request, Equipe $equipe)
    {
        //
    }

    public function destroy(Equipe $equipe)
    {
        //
    }
}
