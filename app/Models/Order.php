<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'order_number',
        'payment_method',
        'payment_details',
        'transaction_id',
        'payment_status',
        'shipping_address_id'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function updateTotalAmount()
    {
        $this->total_amount = $this->orderItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $this->save();
    }
    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }
}
