<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_item_name',
        'order_item_type',
        'product_id',
    ];
}
