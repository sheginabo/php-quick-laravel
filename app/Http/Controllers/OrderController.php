<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Services\OrderService;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    use ValidatesRequests;
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function transferOrder(OrderRequest $request)
    {
        $response = [
            'result' => 'failed',
            'transferredOrder' => null,
            'detail' => []
        ];

        // 使用 OrderService 進行進階驗證
        try {
            $transferredOrder = $this->orderService->transferOrder($request->all());
        } catch (\Throwable $e) {
            $this->handleException($e, $response);
            return response()->json($response, $e->getCode());
        }

        $response['result'] = 'success';
        $response['transferredOrder'] = $transferredOrder;

        return response()->json($response);
    }

    private function handleException(\Throwable $e, array &$response): void
    {
        if (method_exists($e, 'getTarget')) {
            $response['detail'][$e->getTarget()][] = $e->getMessage();
        }
    }
}
