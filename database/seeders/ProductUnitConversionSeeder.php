<?php

namespace Database\Seeders;

use App\Models\ProductUnitConversion;
use Illuminate\Database\Seeder;

class ProductUnitConversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductUnitConversion::truncate();
        ProductUnitConversion::factory()->count(100)->create();
    }
}
