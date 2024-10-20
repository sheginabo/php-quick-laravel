<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\ProductOrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProductOrderControllerTest extends TestCase
{
    protected $headers = ['Accept' => 'application/json'];
    protected $token;

    public function setUp(): void
    {
        parent::setUp();

        // 手動執行 migrate
        Artisan::call('migrate:fresh --seed');

        // Step 1: Create user
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('@Aa12345678')
        ]);

        // Step 2: Login
        $response = $this->postJson('/api/user/login', [
            'email' => 'testuser@example.com',
            'password' => '@Aa12345678'
        ], $this->headers);

        $this->token = $response->json('token');
        $this->headers['Authorization'] = 'Bearer ' . $this->token;
        //print_r($response->json());
    }

    public function testProductOrderFlow()
    {
        //print_r($this->headers);
        // Step 3: Create orders
        $orderData = [
            "currency" => "TW",
            "type" => "A",
            "tax_amount" => 100,
            "total_amount" => 1000,
            "billing_email" => "custom123@yopmail.com",
            "payment_method" => "Free Shipping",
            "payment_method_title" => "Free Shipping",
            "items" => [
                [
                    "product_id" => 1,
                    "order_item_quantity" => 1,
                    "order_item_name" => "Product 1",
                    "order_item_type" => "physical"
                ]
            ]
        ];

//        echo "<pre>";
//        print_r($this->headers);
//        echo "<br>";
//        print_r(Product::all()->toArray());
//        echo "<br>";
//        print_r(User::all()->toArray());
//        echo "</pre>";
//        exit();

        for ($i = 0; $i < 3; $i++) {
            $this->postJson('/api/product/order', $orderData, $this->headers)
                ->assertStatus(200);
        }

        // Step 4: Update first order
        $updateData = [
            "status" => 1,
            "currency" => "TW",
            "type" => "A",
            "tax_amount" => 100,
            "total_amount" => 2000,
            "billing_email" => "custom123@yopmail.com",
            "payment_method" => "Free Shipping",
            "payment_method_title" => "Free Shipping",
            "items" => [
                [
                    "id" => 1,
                    "product_id" => 1,
                    "order_item_quantity" => 2,
                    "order_item_name" => "Product 1",
                    "order_item_type" => "physical"
                ]
            ]
        ];

        $this->patchJson('/api/product/order/1', $updateData, $this->headers)
            ->assertStatus(200);

        // Step 5: Delete first order
        $this->deleteJson('/api/product/order/1', [], $this->headers)
            ->assertStatus(200);

        // Step 6: Get order with id 2
        $this->getJson('/api/product/order/2', $this->headers)
            ->assertStatus(200);

        // Step 7: Get all orders
        $this->getJson('/api/product/order/all', $this->headers)
            ->assertStatus(200);
    }
}
