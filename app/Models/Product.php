<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "categoryId",
        "name",
        "stock",
        "price",
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function discount() {
        return $this->hasMany(Discount::class);
    }

    //RELAÇÃO COM ORDERITEMS
}
