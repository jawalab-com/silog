<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            // Elektronik
            [
                'slug' => 'elektronik',
                'product_name' => 'Smartphone Samsung Galaxy A52 128GB',
            ],
            [
                'slug' => 'elektronik',
                'product_name' => 'Laptop Asus VivoBook 14 A416JA',
            ],
            [
                'slug' => 'elektronik',
                'product_name' => 'TV LED LG 43 Inch Full HD',
            ],
            [
                'slug' => 'elektronik',
                'product_name' => 'Speaker JBL GO2 Portable',
            ],
            [
                'slug' => 'elektronik',
                'product_name' => 'Charger Anker PowerPort+ Quick Charge 3.0',
            ],

            // Pakaian
            [
                'slug' => 'pakaian',
                'product_name' => 'Baju Kaos Polos Size M',
            ],
            [
                'slug' => 'pakaian',
                'product_name' => 'Celana Jeans Levis 501 Size 32',
            ],
            [
                'slug' => 'pakaian',
                'product_name' => 'Sepatu Converse All Star Size 42',
            ],
            [
                'slug' => 'pakaian',
                'product_name' => 'Sandal Eiger Flip Flop Size 41',
            ],
            [
                'slug' => 'pakaian',
                'product_name' => 'Jaket Hoodie Nike Original Size L',
            ],

            // Makanan dan Minuman
            [
                'slug' => 'makanan-dan-minuman',
                'product_name' => 'Indomie Goreng Rasa Ayam Panggang 80g',
            ],
            [
                'slug' => 'makanan-dan-minuman',
                'product_name' => 'Aqua Botol 600ml',
            ],
            [
                'slug' => 'makanan-dan-minuman',
                'product_name' => 'Teh Pucuk Harum 350ml',
            ],
            [
                'slug' => 'makanan-dan-minuman',
                'product_name' => 'Beras Rojolele Premium 5kg',
            ],
            [
                'slug' => 'makanan-dan-minuman',
                'product_name' => 'Kecap Manis ABC 600ml',
            ],

            // Peralatan Rumah Tangga
            [
                'slug' => 'peralatan-rumah-tangga',
                'product_name' => 'Setrika Philips Dry Iron HD1173',
            ],
            [
                'slug' => 'peralatan-rumah-tangga',
                'product_name' => 'Magic Com Miyako 1.8L MCM-609',
            ],
            [
                'slug' => 'peralatan-rumah-tangga',
                'product_name' => 'Rice Cooker Cosmos CRJ-3232 2L',
            ],
            [
                'slug' => 'peralatan-rumah-tangga',
                'product_name' => 'Blender Philips HR2115 1.5L',
            ],
            [
                'slug' => 'peralatan-rumah-tangga',
                'product_name' => 'Kipas Angin Maspion 16 Inch',
            ],

            // Kesehatan dan Kecantikan
            [
                'slug' => 'kesehatan-dan-kecantikan',
                'product_name' => 'Sabun Lifebuoy Cair Refill 450ml',
            ],
            [
                'slug' => 'kesehatan-dan-kecantikan',
                'product_name' => 'Shampo Pantene Anti Ketombe 180ml',
            ],
            [
                'slug' => 'kesehatan-dan-kecantikan',
                'product_name' => 'Pepsodent Pasta Gigi Herbal 120g',
            ],
            [
                'slug' => 'kesehatan-dan-kecantikan',
                'product_name' => 'Masker Spirulina 100% Organik 10g',
            ],
            [
                'slug' => 'kesehatan-dan-kecantikan',
                'product_name' => 'Lipstik Wardah Matte No.11',
            ],

            // Buku dan Alat Tulis
            [
                'slug' => 'buku-dan-alat-tulis',
                'product_name' => 'Buku Tulis Sinar Dunia 40 Lembar',
            ],
            [
                'slug' => 'buku-dan-alat-tulis',
                'product_name' => 'Pulpen Pilot Frixion',
            ],
            [
                'slug' => 'buku-dan-alat-tulis',
                'product_name' => 'Pensil Faber-Castell 2B',
            ],
            [
                'slug' => 'buku-dan-alat-tulis',
                'product_name' => 'Penggaris Plastik 30 cm',
            ],
            [
                'slug' => 'buku-dan-alat-tulis',
                'product_name' => 'Buku Gambar 50 Lembar',
            ],

            // Mainan dan Hobi
            [
                'slug' => 'mainan-dan-hobi',
                'product_name' => 'Mainan LEGO City Fire Truck 128 pcs',
            ],
            [
                'slug' => 'mainan-dan-hobi',
                'product_name' => 'Puzzle 1000 pcs',
            ],
            [
                'slug' => 'mainan-dan-hobi',
                'product_name' => 'Bola Basket Spalding',
            ],
            [
                'slug' => 'mainan-dan-hobi',
                'product_name' => 'Kendama',
            ],
            [
                'slug' => 'mainan-dan-hobi',
                'product_name' => 'Drone Syma X5SW',
            ],
        ];

        $selectedproduct = fake()->unique()->randomElement($products);

        return [
            'id' => fake()->uuid(),
            'product_name' => $selectedproduct['product_name'],
            'brand_id' => function () {
                return Brand::inRandomOrder()->first()->id;
            },
            'tag' => $selectedproduct['slug'],
            'product_description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 0, 1000),
            'verified' => fake()->boolean(),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
