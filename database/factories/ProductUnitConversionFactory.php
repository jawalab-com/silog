<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductUnitConversion;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductUnitConversionFactory extends Factory
{
    protected $model = ProductUnitConversion::class;

    public function definition()
    {
        $product = Product::inRandomOrder()->first();

        return [
            'product_id' => $product->id,
            'from_unit_id' => $product->unit_id,
            'to_unit_id' => function () {
                return Unit::inRandomOrder()->first()->id;
            },
            'factor' => $this->faker->randomFloat(6, 0.1, 10),
        ];
    }
}
