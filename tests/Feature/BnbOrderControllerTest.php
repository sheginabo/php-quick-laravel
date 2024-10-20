<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Exceptions\TransferOrderException;
use App\Services\BnbOrderService;
use App\Http\Requests\BnbOrderRequest;
use Tests\TestCase;

class BnbOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected BnbOrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = new BnbOrderService();
    }

    public function test_name_contains_non_english_characters()
    {
        $response = $this->postJson('/api/bnbOrders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday 旅館',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => "1500",
            'currency' => 'TWD'
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'result' => 'failed',
            'detail' => [
                'name' => [
                    'Name contains non-English characters or is not capitalized'
                ]
            ]
        ]);
    }

    public function test_name_is_not_capitalized()
    {
        $response = $this->postJson('/api/bnbOrders', [
            'id' => 'A0000001',
            'name' => 'Melody holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => "1500",
            'currency' => 'TWD'
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'result' => 'failed',
            'detail' => [
                'name' => [
                    'Name contains non-English characters or is not capitalized'
                ]
            ]
        ]);
    }

    public function test_price_is_over_2000()
    {
        $response = $this->postJson('/api/bnbOrders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => "2050",
            'currency' => 'TWD'
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'result' => 'failed',
            'detail' => [
                'price' => [
                    'Price is over 2000'
                ]
            ]
        ]);
    }

    public function test_currency_format_is_wrong()
    {
        $response = $this->postJson('/api/bnbOrders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => "1500",
            'currency' => 'EUR'
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'result' => 'failed',
            'detail' => [
                'currency' => [
                    'Currency format is wrong'
                ]
            ]
        ]);
    }

    public function test_successful_conversion_to_twd()
    {
        $response = $this->postJson('/api/bnbOrders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => "1500",
            'currency' => 'USD'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'transferredOrder' => [
                'price' => 46500,
                'currency' => 'TWD'
            ]
        ]);
    }

    public function test_successful_transfer_without_conversion()
    {
        $response = $this->postJson('/api/bnbOrders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => "1500",
            'currency' => 'TWD'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'transferredOrder' => [
                'price' => 1500,
                'currency' => 'TWD'
            ]
        ]);
    }
}
