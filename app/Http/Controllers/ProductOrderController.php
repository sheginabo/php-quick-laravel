<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductOrder\ProductOrderCreateRequest;
use App\Http\Requests\ProductOrder\ProductOrderUpdateRequest;
use App\Http\Resources\ProductOrderResource;
use App\Http\Resources\ProductOrderResourceCollection;
use App\Services\ProductOrderService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductOrderController extends Controller
{
    use AuthorizesRequests;
    protected ProductOrderService $productOrderService;

    public function __construct(ProductOrderService $productOrderService)
    {
        $this->productOrderService = $productOrderService;
    }

    public function createOrder(ProductOrderCreateRequest $request): JsonResponse
    {
        $result = $this->productOrderService->createOrder($request->validated());

        $httpStatusCode = ResponseAlias::HTTP_OK;
        if (isset($result['error'])) {
            $httpStatusCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
        }

        return (new ProductOrderResource($result))->response()->setStatusCode($httpStatusCode);
    }

    public function updateOrder(ProductOrderUpdateRequest $request, int $id): JsonResponse
    {
        $result = $this->productOrderService->updateOrder($id, $request->validated());

        $httpStatusCode = ResponseAlias::HTTP_OK;
        if (isset($result['error'])) {
            $httpStatusCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
        }

        return (new ProductOrderResource($result))->response()->setStatusCode($httpStatusCode);
    }

    public function disableOrder(int $id): JsonResponse
    {
        $result = $this->productOrderService->disableOrder($id);

        $httpStatusCode = ResponseAlias::HTTP_OK;
        if (isset($result['error'])) {
            $httpStatusCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
        }

        return (new ProductOrderResource($result))->response()->setStatusCode($httpStatusCode);
    }

    public function getOrder(int $id): JsonResponse
    {
        $result = $this->productOrderService->getOrderById($id);

        $httpStatusCode = ResponseAlias::HTTP_OK;
        if (isset($result['error'])) {
            $httpStatusCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
        }

        return (new ProductOrderResource($result))->response()->setStatusCode($httpStatusCode);
    }

    public function getOrders(): JsonResponse
    {
        $result = $this->productOrderService->getOrdersByUserId();

        $httpStatusCode = ResponseAlias::HTTP_OK;
        if (isset($result['error'])) {
            $httpStatusCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
        }

        return (new ProductOrderResourceCollection(new ProductOrderResource($result)))->response()->setStatusCode($httpStatusCode);
    }
}
