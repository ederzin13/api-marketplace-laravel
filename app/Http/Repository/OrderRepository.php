<?php

namespace App\Http\Repository;

use App\Models\Order;

class OrderRepository {
    public function newOrder(array $data) {
        return Order::create($data);
    }
}