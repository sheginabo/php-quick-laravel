<?php

namespace App\Services\Interfaces;
interface ProductOrderServiceInterface
{
    public function getAllOrders(): string;
    public function createOrder(array $input): string;
    public function getOrderById(array $input): string;
    public function updateOrder(array $input): string;
    public function deleteOrder(array $input): string;
}
