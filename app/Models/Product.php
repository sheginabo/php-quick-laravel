<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'product_name',
        'sku',
        'desc',
        'price',
        'stock_quantity',
        'is_featured',
        'tags',
        'cost_price',
        'is_published',
    ];
}
