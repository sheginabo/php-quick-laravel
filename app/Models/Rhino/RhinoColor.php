<?php

namespace App\Models\Rhino;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RhinoColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'hex_code',
    ];

}
