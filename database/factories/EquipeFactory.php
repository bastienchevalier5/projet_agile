<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 *
 */
class EquipeFactory extends Factory
{

    public function definition(): array
    {
        return [
            'nom' => fake()->name,
        ];
    }

}
