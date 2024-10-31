<?php

namespace App\Models\Rhino;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RhinoProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
    ];

    public function extraFields()
    {
        return $this->hasMany(RhinoProductExtraField::class, 'product_id');
    }
}
