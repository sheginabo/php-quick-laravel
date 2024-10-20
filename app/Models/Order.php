<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'bnb_id',
        'room_id',
        'currency',
        'amount',
        'check_in_date',
        'check_out_date',
        'created_at',
    ];
}
