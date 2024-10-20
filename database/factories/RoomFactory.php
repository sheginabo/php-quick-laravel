<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Bnb;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->word,
            'bnb_id' => Bnb::factory(), // This will create a new Bnb if not provided
        ];
    }
}
