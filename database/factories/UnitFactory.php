<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $units = [
            'Unit',
            'Lusin',
            'Kodi',
            'Rim',
            'Kg',
            'Gram',
            'Liter',
            'Mililiter',
            'Meter',
            'Centimeter',
            'Inci',
            'Meter Kubik',
            'Pack',
            'Botol',
            'Kaleng',
            'Galon',
            'Karung',
            'Dus/Karton',
            'Set',
            'Gross',
        ];

        return [
            'unit_name' => $this->faker->unique()->randomElement($units),
            'unit_description' => fake()->sentence(),
        ];
    }
}
