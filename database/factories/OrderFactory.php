<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Room;
use App\Models\Bnb;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bnb_id' => Bnb::factory(),
            'room_id' => Room::factory(),
            'currency' => $this->faker->randomElement(['USD', 'TWD']),
            'amount' => $this->faker->numberBetween(100, 3000),
            'check_in_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'check_out_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
