<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        // \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Product::factory()->count(35)->create();
    }
}
