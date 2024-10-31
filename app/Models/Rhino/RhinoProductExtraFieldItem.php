<?php

namespace App\Models\Rhino;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RhinoProductExtraFieldItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_id',
        'item_type',
        'sku_part',
        'value',
    ];
}
