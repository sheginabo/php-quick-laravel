<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'status',
        'currency',
        'type',
        'tax_amount',
        'total_amount',
        'user_id',
        'billing_email',
        'date_created_gmt',
        'date_updated_gmt',
        'payment_method',
        'payment_method_title',
        'transaction_id',
        'ip_address',
        'user_agent',
        'customer_note',
    ];

    public function orderItems()
    {
        return $this->hasMany(ProductOrderItem::class, 'order_id', 'id');
    }
}
