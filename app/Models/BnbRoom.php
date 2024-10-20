<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnbRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'bnb_id',
        'name',
    ];

    public function orders()
    {
        return $this->hasMany(BnbOrder::class);
    }
}
