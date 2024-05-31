<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'name', 'email', 'phone', 'address', 'total_amount', 'payment_method', 'transaction_id'];

    // Relationship with cart
    public function orderItems()
    {
        return $this->hasMany(Cart::class);
    }
}
