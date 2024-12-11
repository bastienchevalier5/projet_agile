<?php

namespace Database\Factories;

use App\Models\Motif;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absence>
 */
class AbsenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'debut' => $debut = fake()->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'),
            'fin' => fake()->dateTimeBetween($debut, $debut . ' +3 weeks')->format('Y-m-d'),
            'motif_id' => Motif::factory(),
            'user_id' => User::factory(),

        ];
    }
}
