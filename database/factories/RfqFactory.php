<?php

namespace Database\Factories;

use App\Enums\RfqStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rfq>
 */
class RfqFactory extends Factory
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
            'user_id' => function () {
                return User::inRandomOrder()->first()->id;
            },
            'rfq_number' => implode('/', [fake()->randomNumber(3, true), 0, 'ADMIN', date('m'), date('Y')]),
            'request_date' => fake()->date,
            'total_amount' => fake()->randomFloat(2, 0, 10000000),
            'status' => fake()->randomElement(array_column(RfqStatus::cases(), 'value')),
            'comment' => fake()->sentence,
            'created_at' => fake()->dateTime,
            'updated_at' => fake()->dateTime,
        ];
    }
}
