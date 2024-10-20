<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\BnbOrderService;
use App\Http\Requests\BnbOrderRequest;
use Mockery;
use Illuminate\Support\Facades\Log;

class BnbOrderServiceTest extends TestCase
{
    protected BnbOrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = new BnbOrderService();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_successful_conversion_to_twd()
    {
        // Mock the Log facade
        Log::shouldReceive('debug')->once();
        $request = new BnbOrderRequest([
            'name' => 'Melody Holiday Inn',
            'price' => 1500,
            'currency' => 'USD'
        ]);

        $result = $this->orderService->transferOrder($request->all());

        $this->assertEquals('TWD', $result['currency']);
    }

    public function test_successful_transfer_without_conversion()
    {
        $request = new BnbOrderRequest([
            'name' => 'Melody Holiday Inn',
            'price' => 1500,
            'currency' => 'TWD'
        ]);

        $result = $this->orderService->transferOrder($request->all());

        $this->assertEquals('TWD', $result['currency']);
    }
}
