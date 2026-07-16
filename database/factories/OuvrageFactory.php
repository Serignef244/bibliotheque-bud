<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ouvrage>
 */
class OuvrageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => fake()->sentence(3),
            'auteurs' => fake()->name(),
            'isbn' => fake()->isbn13(),
            'langue' => 'Français',
            'actif' => true,
        ];
    }
}
