<?php

namespace Database\Factories\Rhino;

use App\Models\Rhino\RhinoProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bnb>
 */
class RhinoProductFactory extends Factory
{
    protected $model = RhinoProduct::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'sku' => $this->faker->unique()->lexify('??????')
        ];
    }
}
