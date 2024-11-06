<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Motif>
 */
class MotifFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Liste de motifs d'absence
        $motifs = [
            'Maladie',
            'Congé personnel',
            'Vacances',
            'Accident',
            'Obligations familiales',
            'Congé de maternité/paternité',
            'Formation',
            'Mission professionnelle',
            'Congé sans solde',
            'Grève',
            'Congé sabbatique',
            'Service militaire',
            'Récupération',
            'Absence injustifiée',
            'Jour férié',
            'Déménagement',
            'Entretien médical',
            'Travaux domestiques',
            'Confinement sanitaire',
            'Participation à un évènement'
        ];

        return [
            'Libelle' => fake()->randomElement($motifs),
        ];
    }
}
