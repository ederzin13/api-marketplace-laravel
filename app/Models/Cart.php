<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        "createdAt",
        "userId"
    ];

    public function users() {
        return $this->belongsTo(User::class, "userId", "id");
    }

    public function cartItems() {
        return $this->hasMany(CartItem::class, "cartId", "id");
    }
}
