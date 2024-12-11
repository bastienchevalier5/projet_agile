<?php

namespace Database\Seeders;

use App\Models\User;
use Bouncer;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User;
        $user->name = 'user';
        $user->email = 'user@user.fr';
        $user->password = Hash::make('user');
        $user->poste = 'Random';
        $user->service = 'Lambda';
        $user->age = 25;
        $user->date_embauche = now();
        $user->duree_anciennete = 5;
        $user->save();
        Bouncer::assign('salarie')->to($user);
        Bouncer::allow('salarie')->to('view-absences');
        Bouncer::allow('salarie')->to('create-absences');
        Bouncer::allow('salarie')->to('edit-absences');
        Bouncer::allow('salarie')->to('delete-absences');
        $rh = new User;
        $rh->name = 'RH';
        $rh->email = 'rh@rh.fr';
        $rh->password = Hash::make('rh');
        $rh->poste = 'RH';
        $rh->service = 'RH';
        $rh->age = 35;
        $rh->date_embauche = now();
        $rh->duree_anciennete = 10;
        $rh->save();
        Bouncer::assign('RH')->to($rh);
        Bouncer::allow('RH')->to('view-users');
        Bouncer::allow('RH')->to('edit-users');
        Bouncer::allow('RH')->to('create-users');
        Bouncer::allow('RH')->to('delete-users');
        $responsable = new User;
        $responsable->name = 'responsable';
        $responsable->email = 'responsable@responsable.fr';
        $responsable->password = Hash::make('responsable');
        $responsable->poste = 'Responsable';
        $responsable->service = 'Responsable';
        $responsable->age = 30;
        $responsable->date_embauche = now();
        $responsable->duree_anciennete = 7;
        $responsable->save();
        Bouncer::assign('responsable')->to($responsable);
        Bouncer::allow('responsable')->to('view-planning-users');
        User::factory(10)
            ->create();
    }
}
