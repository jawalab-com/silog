<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseOrder>
 */
class PurchaseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid,
            'supplier_id' => function () {
                return Supplier::inRandomOrder()->first()->id;
            },
            'user_id' => function () {
                return User::inRandomOrder()->first()->id;
            },
            'submission_number' => fake()->randomNumber(5, true),
            'po_number' => strtoupper(fake()->bothify('??###')),
            'order_date' => fake()->date,
            'status' => fake()->randomElement(array_column(OrderStatus::cases(), 'value')),
            'total_amount' => fake()->randomFloat(2, 0, 10000000),
            'created_at' => fake()->dateTime,
            'updated_at' => fake()->dateTime,
        ];
    }
}
