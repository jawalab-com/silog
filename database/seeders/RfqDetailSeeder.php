<?php

namespace Database\Seeders;

use App\Models\RfqDetail;
use Illuminate\Database\Seeder;

class RfqDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RfqDetail::truncate();
        RfqDetail::factory()->count(30)->create();
    }
}
