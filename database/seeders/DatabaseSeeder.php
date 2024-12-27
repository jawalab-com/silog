<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call([
            UserSeeder::class,
            TagSeeder::class,
            UnitSeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            SupplierSeeder::class,
            ProductUnitConversionSeeder::class,
            // RfqSeeder::class,
            // RfqDetailSeeder::class,
            // PurchaseOrderSeeder::class,
        ]);
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
