<?php

namespace App\Models\Rhino;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RhinoInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'sold_out',
        'unlimited',
        'quantity',
        'original_price',
        'discount_price',
    ];
}
