<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $slug = fake()->unique()->slug(2);
        $name = ucfirst(str_replace('-', ' ', $slug));

        return [
            'tag_name' => $name,
            'tag_description' => fake()->sentence(),
            'slug' => $slug,
        ];
    }
}
