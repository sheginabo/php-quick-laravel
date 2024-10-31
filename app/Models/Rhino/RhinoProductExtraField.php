<?php

namespace App\Models\Rhino;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RhinoProductExtraField extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'desc',
        'stock_impact',
        'field_type',
        'display_type',
    ];

    public function extraFieldItems()
    {
        return $this->hasMany(RhinoProductExtraFieldItem::class, 'field_id');
    }
}
