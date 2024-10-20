<?php

namespace App\Services;

use App\Repositories\ProductOrderItemRepository;
use App\Repositories\ProductOrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductOrderService
{
    // Define constants for order statuses
    const ORDER_STATUS_CANCELLED = -1;
    const ORDER_STATUS_SOFT_DELETED = -2;
    protected ProductRepository $productRepository;
    protected ProductOrderRepository $productOrderRepository;
    protected ProductOrderItemRepository $productOrderItemRepository;

    public function __construct(
        ProductRepository $productRepository,
        ProductOrderRepository $productOrderRepository,
        ProductOrderItemRepository $productOrderItemRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productOrderRepository = $productOrderRepository;
        $this->productOrderItemRepository = $productOrderItemRepository;
    }

    public function getOrdersByUserId()
    {
        $userId = auth()->id();
        return $this->productOrderRepository->getOrdersByUserId($userId);
    }

    public function createOrder(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $userId = auth()->id();
                $data['user_id'] = $userId;
                $items = $data['items'];
                unset($data['items']);

                // Generate a unique order number
                $data['order_number'] = 'ORD-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

                // Check stock and lock products
                foreach ($items as $item) {
                    $this->productRepository->decrementStock($item['product_id'], $item['order_item_quantity']);
                }

                // Create order
                $order = $this->productOrderRepository->create($data);

                // Create order items
                foreach ($items as $item) {
                    $this->createOrderItem($item, $order->id);
                }

                return $order;
            });
        } catch (Throwable $e) {
            Log::error('[ProductOrderService_createOrder] Order creation failed: ' . $e->getMessage());
            return [
                'error' => 'Order creation failed',
            ];
        }
    }

    public function updateOrder(int $id, array $data)
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $items = $data['items'] ?? [];
                unset($data['items']);

                // Update order basic information
                $order = $this->productOrderRepository->update($id, $data);

                // Get existing order items
                $existingItems = $this->productOrderItemRepository->getByOrderId($id);
                $existingItemIds = $existingItems->pluck('id')->toArray();
                $updatedItemIds = array_column($items, 'id');

                // Delete removed order items
                $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
                if (!empty($itemsToDelete)) {
                    foreach ($itemsToDelete as $itemId) {
                        $orderItem = $this->productOrderItemRepository->find($itemId);
                        $this->productRepository->incrementStock($orderItem->product_id, $orderItem->order_item_quantity); // Release stock
                        $this->productOrderItemRepository->delete($itemId);
                    }
                }

                // Update or create order items
                foreach ($items as $item) {
                    if (isset($item['id']) && in_array($item['id'], $existingItemIds)) {
                        $this->updateOrderItem($item);
                    } else {
                        $this->createOrderItem($item, $order->id);
                    }
                }

                // Soft delete the entire order if no items left
                if ($this->productOrderRepository->isOrderNeedCancel($order)) {
                    Log::info('[ProductOrderService_updateOrder] Cancel order: ' . $order->order_number);
                    $this->productOrderRepository->update($id, ['status' => config('productOrderStatus.ORDER_STATUS_CANCELLED')]);
                }

                return $order;
            });
        } catch (Throwable $e) {
            Log::error('[ProductOrderService_updateOrder] Order update failed: ' . $e->getMessage());
            return [
                'error' => 'Order update failed',
            ];
        }
    }

    public function disableOrder(int $id)
    {
        try {
            return DB::transaction(function () use ($id) {
                return $this->productOrderRepository->update($id, ['status' => config('productOrderStatus.ORDER_STATUS_SOFT_DELETED')]);
            });
        } catch (Throwable $e) {
            Log::error('[ProductOrderService_updateOrder] Order disable failed: ' . $e->getMessage());
            return [
                'error' => 'Order disable failed',
            ];
        }
    }

    public function getOrderById(int $id)
    {
        return $this->productOrderRepository->find($id);
    }

    /**
     * @throws \Exception
     */
    private function updateOrderItem(array $item): void
    {
        $orderItem = $this->productOrderItemRepository->find($item['id']);
        $stockChange = $item['order_item_quantity'] - $orderItem->order_item_quantity;

        if ($stockChange > 0) {
            $this->productRepository->decrementStock($item['product_id'], $stockChange);
        } elseif ($stockChange < 0) {
            $this->productRepository->incrementStock($item['product_id'], abs($stockChange));
        }

        if ($item['order_item_quantity'] == 0) {
            $this->productOrderItemRepository->delete($item['id']);
        } else {
            $this->productOrderItemRepository->update($item['id'], $item);
        }
    }

    /**
     * @throws \Exception
     */
    private function createOrderItem(array $item, int $orderId): void
    {
        if ($item['order_item_quantity'] > 0) {
            $this->productRepository->decrementStock($item['product_id'], $item['order_item_quantity']);
            $this->productOrderItemRepository->create([
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'order_item_quantity' => $item['order_item_quantity'],
                'order_item_name' => $item['order_item_name'],
                'order_item_type' => $item['order_item_type'],
            ]);
        }
    }
}
