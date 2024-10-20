<?php

namespace App\Repositories;

use App\Models\ProductOrder;

class ProductOrderRepository
{

    protected ProductOrder $model;

    public function __construct(ProductOrder $model)
    {
        $this->model = $model;
    }

    public function getOrdersByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->where('status', '!=', config('productOrderStatus.ORDER_STATUS_SOFT_DELETED'))->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }



    public function update(int $id, array $data)
    {
        $order = $this->model->findOrFail($id);
        $order->update($data);
        return $order;
    }

    public function delete(int $id): void
    {
        $order = $this->model->findOrFail($id);
        $order->delete();
    }

    public function isOrderNeedCancel(ProductOrder $order): bool
    {
        $result = false;

        if ($order->orderItems()->count() == 0) {
            $result = true;
        }

        return $result;
    }

    public function isOwnedByUser(int $orderId, int $userId): bool
    {
        return $this->model->where('id', $orderId)->where('user_id', $userId)->exists();
    }
}
