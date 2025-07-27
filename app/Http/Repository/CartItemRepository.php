<?php

namespace App\Http\Repository;

use App\Models\CartItem;

class CartItemRepository {
    public function getItems($id) {
        return CartItem::where("cartId", "=", $id)->get();
    }

    public function addItem(array $data) {
        return CartItem::create($data);
    }

    public function updateItem(array $data) {

    }
}