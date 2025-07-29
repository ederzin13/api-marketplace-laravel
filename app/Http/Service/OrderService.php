<?php

namespace App\Http\Service;

use App\Http\Repository\OrderItemRepository;
use App\Http\Repository\OrderRepository;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class OrderService {
    public function __construct(
        protected OrderRepository $repository,
        protected OrderItemRepository $orderItemRepository
        ) {}

    public function getAll() {
        return $this->repository->getAll();
    }

    public function newOrder(array $data) {
        $user = Auth::user();

        $items = CartItem::where("cartId", "=", $user->cart->id)->get();

        $order = $this->repository->newOrder([
            "userId" => $user->id,
            "addressId" => $data["addressId"],
            "orderDate" => now(),
            "couponId" => null,
            "status" => "pending",
            "totalAmount" => $this->totalAmount($items)
        ]);

        dd($items, $order);
        // return $this->repository->newOrder($data);
    }

    public function totalAmount($items) {
        $total = 0;

        foreach ($items as $item) {
            $itemPrice = $item->quantity * $item->unitPrice;

            $total += $itemPrice;
        }

        return $total;
    }
}