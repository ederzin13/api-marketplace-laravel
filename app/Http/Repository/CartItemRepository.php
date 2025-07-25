<?php

namespace App\Http\Repository;

use App\Models\CartItem;

class CartItemRepository {
    public function getAll($id) {
        return CartItem::where("cartId", "=", $id)->get();
    }

    public function addItem(array $data) {
        return CartItem::create($data);
    }
}