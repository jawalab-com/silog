<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $tags = [
            [
                'id' => 'd3b07384-3f3f-41a8-b25f-09db097c548e',
                'tag_name' => 'Elektronik',
            ],
            [
                'id' => 'a4e2873e-3d4e-4936-8dd3-8b4e6fc2e5f3',
                'tag_name' => 'Pakaian',
            ],
            [
                'id' => 'f3e86c9a-874d-41ec-a68a-9cfd53e5d7b7',
                'tag_name' => 'Makanan dan Minuman',
            ],
            [
                'id' => 'b7f763c9-c62b-43e9-939d-073bb39a68c1',
                'tag_name' => 'Peralatan Rumah Tangga',
            ],
            [
                'id' => 'c5dfe812-42de-4b99-a8b2-0d7326c2be3e',
                'tag_name' => 'Kesehatan dan Kecantikan',
            ],
            [
                'id' => 'd8f9e99f-f61d-40e7-9e0d-2b9f2e8c4763',
                'tag_name' => 'Buku dan Alat Tulis',
            ],
            [
                'id' => 'f9d8b8c7-4963-4f89-97a7-1c2e3f5d59cd',
                'tag_name' => 'Mainan dan Hobi',
            ],
        ];

        $selectedTag = fake()->unique()->randomElement($tags);
        $slug = Str::slug($selectedTag['tag_name'], '-');

        return [
            'id' => $selectedTag['id'],
            'tag_name' => $selectedTag['tag_name'],
            'tag_description' => fake()->sentence(3),
            'slug' => $slug,
        ];
    }
}
