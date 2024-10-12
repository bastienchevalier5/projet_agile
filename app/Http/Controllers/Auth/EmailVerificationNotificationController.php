<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Vérifiez si l'utilisateur est authentifié
        if (! $user) {
            return redirect()->route('login');
        }

        // Vérifiez si l'utilisateur a déjà vérifié son email
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('accueil', absolute: false));
        }

        // Envoyer la notification de vérification d'email
        $user->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
