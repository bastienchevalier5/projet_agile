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
        $admin = new User;
        $admin->name = 'admin';
        $admin->email = 'admin@admin.fr';
        $admin->password = Hash::make('admin');
        $admin->save();
        Bouncer::assign('admin')->to($admin);
        Bouncer::allow('admin')->to('view-motifs');
        Bouncer::allow('admin')->to('create-motifs');
        Bouncer::allow('admin')->to('edit-motifs');
        Bouncer::allow('admin')->to('delete-motifs');
        Bouncer::allow('admin')->to('view-absences');
        Bouncer::allow('admin')->to('create-absences');
        Bouncer::allow('admin')->to('edit-absences');
        Bouncer::allow('admin')->to('delete-absences');
        Bouncer::allow('admin')->to('view-users');
        Bouncer::allow('admin')->to('create-users');
        Bouncer::allow('admin')->to('edit-users');
        Bouncer::allow('admin')->to('delete-users');
        User::factory(10)
            ->create();
    }
}
