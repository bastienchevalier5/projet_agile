<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();

        // Vérifiez si l'utilisateur est authentifié avant d'appeler hasVerifiedEmail()
        if ($user) {
            return $user->hasVerifiedEmail()
                        ? redirect()->intended(route('accueil', absolute: false))
                        : view('auth.verify-email');
        }

        // Si l'utilisateur n'est pas authentifié, vous pouvez rediriger ou afficher une vue appropriée
        return redirect()->route('login');
    }
}
