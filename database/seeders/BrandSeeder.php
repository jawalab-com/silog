<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Brand::truncate();
        // \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Brand::factory()->count(15)->create();
    }
}
