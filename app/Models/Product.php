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
        'weight',
        'dimensions',
        'category_id',
        'created_at',
        'updated_at',
        'manufacturer',
        'is_featured',
        'tags',
        'barcode',
        'warranty_period',
        'cost_price',
        'tax_class',
        'visibility',
    ];
}
