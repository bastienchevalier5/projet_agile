<?php

namespace Database\Seeders;

use App\Models\Equipe;
use Illuminate\Database\Seeder;

class EquipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Equipe::factory(2)
            ->create();
    }
}
