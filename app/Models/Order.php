<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "userId",
        "addressId",
        "orderDate",
        "couponId",
        "status",
        "totalAmount"
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function addresses() {
        return $this->belongsTo(Address::class);
    }
}
