<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bnb>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => 1,
            'product_name' => $this->faker->words(3, true),
            'sku' => $this->faker->unique()->bothify('SKU-####'),
            'desc' => $this->faker->optional()->paragraph,
            'price' => $this->faker->randomFloat(8, 0, 1000),
            'stock_quantity' => 10000,
            'is_featured' => $this->faker->randomElement([0, 1]),
            'tags' => $this->faker->optional()->words(5, true),
            'cost_price' => $this->faker->optional()->randomFloat(8, 0, 500),
            'is_published' => 1,
        ];
    }
}
