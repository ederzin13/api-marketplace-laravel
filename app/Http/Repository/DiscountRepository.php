<?php

namespace App\Http\Repository;

use App\Models\Discount;

class DiscountRepository {
    public function getAll() {
        return Discount::all();
    }

    public function getOne($id) {
        return Discount::findOrFail($id);
    }

    public function newDiscount(array $data) {
        return Discount::create($data);
    }

    public function updateDiscount(array $data, $id) {
        return Discount::where($id)->update($data);
    }

    public function deleteDiscount($id) {
        return Discount::destroy($id);
    }
}