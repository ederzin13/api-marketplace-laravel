<?php

namespace App\Http\Repository;

use App\Models\Order;

class OrderRepository {
    public function getAll() {
        return Order::all();
    }

    public function getMyOrders($id) {
        return Order::where("userId", "=", $id)->get();
    }

    public function getOne($id) {
        return Order::findOrFail($id);
    }

    public function newOrder(array $data) {
        return Order::create($data);
    }

    public function updateStatus($status, $id) {
        return Order::where("id", "=", $id)->update($status);
    }

    public function deleteOrder($id) {
        return Order::destroy($id);
    }
}