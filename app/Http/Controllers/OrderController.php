<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Services\OrderService;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\JsonResponse;


class OrderController extends Controller
{
    use ValidatesRequests;
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function transferOrder(OrderRequest $request): JsonResponse
    {
        $response = [
            'result' => 'failed',
            'transferredOrder' => null,
            'detail' => []
        ];

        $transferredOrder = $this->orderService->transferOrder($request->validated());

        $response['result'] = 'success';
        $response['transferredOrder'] = new OrderResource($transferredOrder);

        return response()->json($response);
    }

}
