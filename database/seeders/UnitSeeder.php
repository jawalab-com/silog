<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		Unit::truncate();
		\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		Unit::factory()->count(10)->create();
	}
}
