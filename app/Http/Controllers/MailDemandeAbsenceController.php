<?php

namespace App\Http\Controllers;

use App\Mail\MailDemandeAbsence;
use App\Models\Absence;
use App\Models\User;
use Bouncer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailDemandeAbsenceController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Récupérer l'absence par son ID
        $absence = Absence::findOrFail($request->id);

        $admins = Bouncer::role('admin')->users;

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new MailDemandeAbsence($absence));
        }

        return redirect()->route('absence.index')->with('success', "Un mail a été envoyé aux administrateurs lui indiquant votre demande");
    }
}
