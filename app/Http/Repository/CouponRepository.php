<?php

namespace App\Http\Repository;

use App\Models\Coupon;

class CouponRepository {
    public function getAll() {
        return Coupon::all();
    }

    public function getOne($id) {
        return Coupon::findOrFail($id);
    }

    public function createCoupon(array $data) {
        return Coupon::create($data);
    }

    public function updateCoupon(array $data, $id) {
        return Coupon::where("id", "=", $id)->update($data);
    }

    public function deleteCoupon($id) {
        return Coupon::destroy($id);
    }
}