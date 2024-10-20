<?php

namespace Database\Seeders;

use App\Models\BnbOrder;
use App\Models\Bnb;
use App\Models\BnbRoom;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        // Create Bnb records
        $bnbs = Bnb::factory(3)->create(['created_at' => now()->setDate(2022, 12, rand(1, 31))]);
        // Create rooms for each Bnb
        $bnbs->each(function ($bnb) {
            $rooms = BnbRoom::factory(rand(1, 2))->create([
                'bnb_id' => $bnb->id,
                'created_at' => now()->setDate(2023, 1, rand(1, 31)),
            ]);
            // Create orders for each room
            $rooms->each(function ($room) {
                BnbOrder::factory(rand(1, 3))->create([
                    'bnb_id' => $room->bnb_id,
                    'room_id' => $room->id,
                    'created_at' => now()->setDate(2023, 5, rand(1, 31)),
                ]);
            });
        });

        // Create Fake Product
        Product::factory(3)->create();
    }
}
