<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Models\JoursSensibles;

class VerifierDateSensibleProche
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $today=date("y.m.d");
        $jourssensibles = JoursSensibles::all();
        $users = User::all();
        foreach($jourssensibles as $joursensible)
        {
            if($joursensible->debut == date_add(7, $today)){
                foreach ($users as $user){
                    if($user->equipe_id == $joursensible->equipe_id){
                        Mail::to($user->email)->send(new MailRappelDateSensible($joursensible));
                    }
                }
                $joursensible->notifie = 1;
                $joursensible->save;
            }
        }
        return $next($request);
    }
}
