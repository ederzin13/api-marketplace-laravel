<?php

namespace App\Http\Repository;

use App\Models\OrderItem;

class OrderItemRepository {
    public function storeItems(array $data) {
        return OrderItem::create($data);
    }
}