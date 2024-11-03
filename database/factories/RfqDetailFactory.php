<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RfqDetail>
 */
class RfqDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 10);
        $unitPrice = fake()->randomFloat(2, 1000, 100000);

        return [
            'rfq_id' => function () {
                return Rfq::inRandomOrder()->first()->id;
            },
            'product_id' => function () {
                return Product::inRandomOrder()->first()->id;
            },
            'quantity' => fake()->numberBetween(1, 10),
            'unit_id' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $quantity * $unitPrice,
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
