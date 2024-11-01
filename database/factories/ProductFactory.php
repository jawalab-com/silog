<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Tag;
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
            'Indomie Goreng Rasa Ayam Panggang 80g',
            'Aqua Botol 600ml',
            'Teh Pucuk Harum 350ml',
            'Biskuit Roma Kelapa 200g',
            'Beras Rojolele Premium 5kg',
            'Minyak Goreng Bimoli 2L',
            'Sabun Lifebuoy Cair Refill 450ml',
            'Shampo Pantene Anti Ketombe 180ml',
            'Pepsodent Pasta Gigi Herbal 120g',
            'Sikat Gigi Formula Junior',
            'Kopi Kapal Api Special Mix 10 Sachet',
            'Susu Ultra Milk Cokelat 250ml',
            'Yakult Botol 5x65ml',
            'Mie Sedaap Kuah Kari 80g',
            'Kecap Manis ABC 600ml',
            'Saus Sambal Indofood Extra Pedas 335ml',
            'Sirup Marjan Cocopandan 500ml',
            'Buku Tulis Sinar Dunia 40 Lembar',
            'Pulpen Pilot Frixion',
            'Pensil Faber-Castell 2B',
            'Setrika Philips Dry Iron HD1173',
            'Magic Com Miyako 1.8L MCM-609',
            'Rice Cooker Cosmos CRJ-3232 2L',
            'Kompor Gas Rinnai 2 Tungku RI-522E',
            'Kipas Angin Maspion 16 Inch',
            'Blender Philips HR2115 1.5L',
            'Senter Krisbow LED 500 Lumens',
            'Lampu LED Philips 12W',
            'Baju Kaos Polos Size M',
            'Celana Jeans Levis 501 Size 32',
            'Sepatu Converse All Star Size 42',
            'Sandal Eiger Flip Flop Size 41',
            'Tas Selempang Palomino Kecil',
            'Jaket Hoodie Nike Original Size L',
            'Topi Baseball Adidas Adjustable',
            'Handuk Terry Palmer 70x140cm',
            'Bedak Marcks Beauty Powder 20g',
            'Lipstik Wardah Matte No.11',
            'Masker Spirulina 100% Organik 10g',
            'Parfum Gatsby Urban Cologne 100ml',
            'Pomade Suavecito Original 113g',
            'Gelang Tali Etnik Handmade',
            'Dompet Kulit Pria Brown',
            'Mainan LEGO City Fire Truck 128 pcs',
            'Smartphone Samsung Galaxy A52 128GB',
            'Laptop Asus VivoBook 14 A416JA',
            'TV LED LG 43 Inch Full HD',
            'Speaker JBL GO2 Portable',
            'Powerbank Xiaomi Mi 10000mAh',
            'Charger Anker PowerPort+ Quick Charge 3.0',
            'USB Flashdisk Sandisk 64GB',
        ];

        return [
            'id' => fake()->uuid(),
            'product_name' => fake()->unique()->randomElement($products),
            'brand_id' => function () {
                return Brand::inRandomOrder()->first()->id;
            },
            'tag' => function () {
                return Tag::inRandomOrder()->first()->slug;
            },
            'product_description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 0, 1000),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
