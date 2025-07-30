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

    public function getMyOrders() {
        $user = Auth::user();

        return $this->repository->getMyOrders($user->id);
    }

    public function getOne($id) {
        return $this->repository->getOne($id);
    }

    public function newOrder(array $data) {
        $user = Auth::user();

        $items = CartItem::where("cartId", "=", $user->cart->id)->get();

        $order = $this->repository->newOrder([
            "userId" => $user->id,
            "addressId" => $data["addressId"],
            "orderDate" => now(),
            "couponId" => $data["couponId"] ?? null,
            "status" => "pending",
            "totalAmount" => $this->totalAmount($items)
        ]);

        dd($items, $order);
        // return $this->repository->newOrder($data);
    }

    public function updateStatus($status, $id) {
        return $this->repository->updateStatus($status, $id);
    }

    public function totalAmount($items) {
        $total = 0;

        foreach ($items as $item) {
            $itemPrice = $item->quantity * $item->unitPrice;

            $total += $itemPrice;
        }

        return $total;
    }

    public function orderBelongsToUser($id) {
       $user = Auth::user();

        $order = $this->getOne($id);

        if ($user->id != $order->userId) {
            return [
                "message" => "Pedido não pertence a esse usuário" //ou algo do gênero
            ];
        }
    }

    public function cancelOrder($id) {
        $this->orderBelongsToUser($id);

        return $this->repository->deleteOrder($id);
    }
}