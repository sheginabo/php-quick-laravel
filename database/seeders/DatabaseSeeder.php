<?php

namespace Database\Seeders;

use App\Models\Bnb;
use App\Models\BnbOrder;
use App\Models\BnbRoom;
use App\Models\Product;
use App\Models\Rhino\RhinoColor;
use App\Models\Rhino\RhinoDevice;
use App\Models\Rhino\RhinoInventory;
use App\Models\Rhino\RhinoProduct;
use App\Models\Rhino\RhinoProductExtraField;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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

        // Create Fake Product
        Product::factory(3)->create();
        // Create Bnb records
        $this->createBnbData();
        // Create RhinoProduct with extras
        $this->createRhinoProductWithExtras();
    }

    private function createRhinoProductWithExtras(): void
    {
        $solidSuit = RhinoProduct::factory()->create([
            'name' => 'SolidSuit',
            'desc' => 'This is SolidSuit',
        ]);

        // Create solidSuit's extra fields
        $fieldDeviceType = RhinoProductExtraField::create([
            'product_id' => $solidSuit->id,
            'name' => 'device type',
            'stock_impact' => true,
            'field_type' => 'product',
            'display_type' => 'select',
        ]);
        $fieldProductType = RhinoProductExtraField::create([
            'product_id' => $solidSuit->id,
            'name' => 'product type',
            'stock_impact' => true,
            'field_type' => 'product',
            'display_type' => 'radio',
        ]);
        $fieldProductColor = RhinoProductExtraField::create([
            'product_id' => $solidSuit->id,
            'name' => 'product color',
            'stock_impact' => true,
            'field_type' => 'product',
            'display_type' => 'radio',
        ]);

        // Create Fake RhinoProductExtraFieldItem
        $fieldDeviceType->extraFieldItems()->createMany([
            [
                'field_id' => $fieldDeviceType->id,
                'sku_part' => 'i16',
                'value' => 'iPhone 16',
            ],
            [
                'field_id' => $fieldDeviceType->id,
                'sku_part' => 'i16pro',
                'value' => 'iPhone 16 Pro',
            ],
            [
                'field_id' => $fieldDeviceType->id,
                'sku_part' => 'i16promax',
                'value' => 'iPhone 16 Pro Max',
            ],
        ]);

        $fieldProductType->extraFieldItems()->createMany([
            [
                'field_id' => $fieldProductType->id,
                'sku_part' => 's',
                'value' => 'Standard',
            ],
            [
                'field_id' => $fieldProductType->id,
                'sku_part' => 'm',
                'value' => 'MagSafe',
            ],
        ]);

//        $fieldProductColor->extraFieldItems()->createMany([
//            [
//                'field_id' => $fieldProductColor->id,
//                'sku_part' => 'black',
//                'value' => 'Black',
//            ],
//            [
//                'field_id' => $fieldProductColor->id,
//                'sku_part' => 'white',
//                'value' => 'White',
//            ],
//            [
//                'field_id' => $fieldProductColor->id,
//                'sku_part' => 'red',
//                'value' => 'Red',
//            ],
//        ]);

        $rhinoColor1 = RhinoColor::create([
            'code' => '0B',
            'name' => '貝殼灰',
            'hex_code' => '#D0CAC0',
        ]);

        $rhinoColor2 =RhinoColor::create([
            'code' => '0A',
            'name' => '深海藍',
            'hex_code' => '#547F90',
        ]);

        $rhinoDevice = RhinoDevice::create([
            'name' => 'iPhone 16',
        ]);

        RhinoDevice::create([
            'name' => 'iPhone 16 Pro',
        ]);

        // Attach color to device
        $rhinoDevice->colors()->attach([$rhinoColor1->id, $rhinoColor2->id]);

        // create inventory
        RhinoInventory::create([
            'sku' => 'i16-s-0A',
            'quantity' => 100,
            'original_price' => 830,
            'discount_price' => 747,
        ]);
        RhinoInventory::create([
            'sku' => 'i16-s-0B',
            'quantity' => 100,
            'original_price' => 730,
            'discount_price' => 657,
        ]);
    }

    private function createBnbData(): void
    {
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
    }
}
