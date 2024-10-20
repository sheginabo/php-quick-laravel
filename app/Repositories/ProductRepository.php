<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    protected Product $model;

    public function __construct(Product $model)
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

    public function findForUpdate(int $productId)
    {
        return $this->model->where('id', $productId)->lockForUpdate()->first();
    }

    /**
     * @throws \Exception
     */
    public function decrementStock(int $productId, int $quantity): void
    {
        $product = $this->findForUpdate($productId);

        if ($product->stock_quantity < $quantity) {
            throw new \Exception('[ProductRepository_decrementStock] Insufficient stock for product ID: ' . $productId);
        }

        $product->decrement('stock_quantity', $quantity);
    }

    public function incrementStock(int $productId, int $quantity): void
    {
        $product = $this->findForUpdate($productId);
        $product->increment('stock_quantity', $quantity);
    }
}
