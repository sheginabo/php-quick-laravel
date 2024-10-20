<?php

namespace App\Http\Controllers;

use App\Http\Resources\BnbOrderResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Services\BnbOrderService;
use App\Http\Requests\BnbOrderRequest;
use Illuminate\Http\JsonResponse;


class BnbOrderController extends Controller
{
    use ValidatesRequests;
    protected BnbOrderService $orderService;

    public function __construct(BnbOrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function transferOrder(BnbOrderRequest $request): JsonResponse
    {
        $response = [
            'result' => 'failed',
            'transferredOrder' => null,
            'detail' => []
        ];

        $transferredOrder = $this->orderService->transferOrder($request->validated());

        $response['result'] = 'success';
        $response['transferredOrder'] = new BnbOrderResource($transferredOrder);

        return response()->json($response);
    }

}
