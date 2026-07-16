<?php

namespace Database\Factories;

use App\Models\Ouvrage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exemplaire>
 */
class ExemplaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ouvrage_id' => Ouvrage::factory(),
            'code_barre' => fake()->unique()->numerify('BUD-######'),
            'statut' => \App\Enums\StatutExemplaire::DISPONIBLE,
            'etat' => 5,
        ];
    }
}
