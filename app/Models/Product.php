<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "categoryId",
        "name",
        "stock",
        "price",
    ];

    public function category() {
        return $this->belongsTo(Category::class, "categoryId", "id");
    }

    public function discount() {
        return $this->hasMany(Discount::class, "productId", "id");
    }

    //RELAÇÃO COM ORDERITEMS
    public function orderItems() {
        return $this->hasMany(OrderItem::class, "productId", "id");
    }
}
