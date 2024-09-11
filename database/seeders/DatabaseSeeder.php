<?php

namespace Database\Seeders;
use app\Models\Absence;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        (new MotifSeeder)->run();
        (new AbsenceSeeder)->run();
         // User::factory(10)->create();

        //  User::factory()->create([
        //    'name' => 'Test User',
        //  'email' => 'test@example.com',
        //]);
    }
}
