<?php

namespace App\Models\Rhino;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RhinoDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
    ];

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(RhinoColor::class, 'rhino_device_colors', 'device_id', 'color_id');
    }
}
