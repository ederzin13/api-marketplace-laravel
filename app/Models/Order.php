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
        return $this->belongsTo(User::class, "userId", "id");
    }

    public function addresses() {
        return $this->belongsTo(Address::class, "addressId", "id");
    }

    public function coupons() {
        return $this->hasOne(Coupon::class, "couponId");
    }
}
