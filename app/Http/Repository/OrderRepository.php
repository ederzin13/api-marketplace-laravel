<?php

namespace App\Http\Repository;

use App\Models\Order;

class OrderRepository {
    public function getAll() {
        return Order::all();
    }

    public function newOrder(array $data) {
        return Order::create($data);
    }
}