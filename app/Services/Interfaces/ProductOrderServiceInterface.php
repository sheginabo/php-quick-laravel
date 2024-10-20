<?php

namespace App\Services\Interfaces;
interface ProductOrderServiceInterface
{
    public function getOrdersByUserId();
    public function createOrder(array $data);
    public function updateOrder(int $id, array $data);
    public function disableOrder(int $id);
    public function getOrderById(int $id);
}
