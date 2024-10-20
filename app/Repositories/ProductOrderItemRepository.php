<?php

namespace App\Repositories;

use App\Models\ProductOrderItem;

class ProductOrderItemRepository
{
    protected ProductOrderItem $model;

    public function __construct(ProductOrderItem $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function getByOrderId(int $orderId)
    {
        return $this->model->where('order_id', $orderId)->get();
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
}
