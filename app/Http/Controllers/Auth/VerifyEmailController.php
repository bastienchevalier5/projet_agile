<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Vérifie si l'utilisateur est authentifié
        if (is_null($user)) {
            return redirect()->route('login');
        }

        // Vérifie si l'email est déjà vérifié
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('accueil', absolute: false).'?verified=1');
        }

        // Marque l'email comme vérifié et déclenche l'événement
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->intended(route('accueil', absolute: false).'?verified=1');
    }
}
