<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		Supplier::truncate();
		\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		Supplier::factory()->count(50)->create();
	}
}
