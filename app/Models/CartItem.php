<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        "cartId",
        "productId",
        "quantity",
        "unitPrice"
    ];

    public function carts() {
        return $this->belongsTo(Cart::class);
    }
}
