<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        "orderId",
        "productId",
        "quantity",
        "unitPrice"
    ];

    public function products() {
        return $this->belongsTo(Product::class);
    }
}
