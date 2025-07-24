<?php

namespace App\Http\Repository;

use App\Models\Cart;

class CartRepository {
    public function getAll() {
        return Cart::all();
    }

    public function createCart($id) {
        return Cart::create([
            "userId" => $id,
            "createdAt" => now()
        ]);
    }
}