<?php

namespace Database\Seeders;

use App\Models\Rfq;
use Illuminate\Database\Seeder;

class RfqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rfq::truncate();
        Rfq::factory()->count(3)->create();
    }
}
