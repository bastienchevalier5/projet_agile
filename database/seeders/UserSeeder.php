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
        $rh->save();
        Bouncer::assign('rh')->to($rh);
        Bouncer::allow('rh')->to('view-motifs');
        Bouncer::allow('rh')->to('create-motifs');
        Bouncer::allow('rh')->to('edit-motifs');
        Bouncer::allow('rh')->to('delete-motifs');
        Bouncer::allow('rh')->to('view-absences');
        Bouncer::allow('rh')->to('create-absences');
        Bouncer::allow('rh')->to('edit-absences');
        Bouncer::allow('rh')->to('delete-absences');
        Bouncer::allow('rh')->to('view-users');
        Bouncer::allow('rh')->to('create-users');
        Bouncer::allow('rh')->to('edit-users');
        Bouncer::allow('rh')->to('delete-users');
        $responsable = new User;
        $responsable->name = 'responsable';
        $responsable->email = 'responsable@responsable.fr';
        $responsable->password = Hash::make('responsable');
        $responsable->save();
        Bouncer::assign('responsable')->to($responsable);
        Bouncer::allow('responsable')->to('view-planning-users');
        User::factory(10)
            ->create();
    }
}
