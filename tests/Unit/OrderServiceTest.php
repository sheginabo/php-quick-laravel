<?php

namespace Tests\Unit;

use App\Exceptions\TransferOrderException;
use PHPUnit\Framework\TestCase;
use App\Services\OrderService;
use App\Http\Requests\OrderRequest;
use Mockery;
use Illuminate\Support\Facades\Log;

class OrderServiceTest extends TestCase
{
    protected OrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = new OrderService();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_name_contains_non_english_characters()
    {
        $this->expectException(TransferOrderException::class);
        $this->expectExceptionMessage('Name contains non-English characters');

        $request = new OrderRequest([
            'name' => 'Melody Holiday 旅館',
            'price' => 1500,
            'currency' => 'TWD'
        ]);

        $this->orderService->transferOrder($request->all());
    }

    public function test_name_is_not_capitalized()
    {
        $this->expectException(TransferOrderException::class);
        $this->expectExceptionMessage('Name is not capitalized');

        $request = new OrderRequest([
            'name' => 'Melody holiday Inn',
            'price' => 1500,
            'currency' => 'TWD'
        ]);

        $this->orderService->transferOrder($request->all());
    }

    public function test_price_is_over_2000()
    {
        $this->expectException(TransferOrderException::class);
        $this->expectExceptionMessage('Price is over 2000');

        $request = new OrderRequest([
            'name' => 'Melody Holiday Inn',
            'price' => 2050,
            'currency' => 'TWD'
        ]);

        $this->orderService->transferOrder($request->all());
    }

    public function test_currency_format_is_wrong()
    {
        $this->expectException(TransferOrderException::class);
        $this->expectExceptionMessage('Currency format is wrong');

        $request = new OrderRequest([
            'name' => 'Melody Holiday Inn',
            'price' => 1500,
            'currency' => 'EUR'
        ]);

        $this->orderService->transferOrder($request->all());
    }

    public function test_successful_conversion_to_twd()
    {
        // Mock the Log facade
        Log::shouldReceive('debug')->once();
        $request = new OrderRequest([
            'name' => 'Melody Holiday Inn',
            'price' => 1500,
            'currency' => 'USD'
        ]);

        $result = $this->orderService->transferOrder($request->all());

        $this->assertEquals('TWD', $result['currency']);
    }

    public function test_successful_transfer_without_conversion()
    {
        $request = new OrderRequest([
            'name' => 'Melody Holiday Inn',
            'price' => 1500,
            'currency' => 'TWD'
        ]);

        $result = $this->orderService->transferOrder($request->all());

        $this->assertEquals('TWD', $result['currency']);
    }
}
