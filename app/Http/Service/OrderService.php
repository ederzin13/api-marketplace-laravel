<?php

namespace App\Http\Service;

use App\Http\Repository\OrderItemRepository;
use App\Http\Repository\OrderRepository;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderService {
    public function __construct(
        protected OrderRepository $repository,
        protected OrderItemRepository $orderItemRepository,
        protected ProductService $productService
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

        $couponDiscount = null;

        //se couponId não estiver vazio, a expressão retorna true
        if (!empty($data["couponId"])) {
            $coupon = Coupon::findOrFail($data["couponId"]);

            $couponDiscount = $coupon->discountPercentage / 100;
        }

        $finalItems = [];

        foreach ($items as $item) {
            $product = Product::findOrFail($item->productId);

            $discountedPrice = $this->productService->applyDiscount($product->id) ?? $product->price;

            $finalItems[] = (object) [
                "productId" => $product->id,
                "quantity" => $item->quantity,
                "unitPrice" => $discountedPrice
            ];
        }

        $order = $this->repository->newOrder([
            "userId" => $user->id,
            "addressId" => $data["addressId"],
            "orderDate" => now(),
            "couponId" => $data["couponId"] ?? null,
            "status" => "pending",
            "totalAmount" => $this->totalAmount($finalItems, $couponDiscount)
        ]);

        $this->storeOrderItem($items);
    }

    public function storeOrderItem($items) {
        $order = Order::latest()->first();

        foreach ($items as $item) {
            $this->orderItemRepository->storeItems([
                "orderId" => $order->id,
                "productId" => $item->productId,
                "quantity" => $item->quantity,
                "unitPrice" => $item->unitPrice
            ]);
        }
    }

    public function updateStatus($status, $id) {
        return $this->repository->updateStatus($status, $id);
    }

    public function totalAmount($items, $couponDiscount) {//ajeitar essa continha aqui 
        $total = 0;

        foreach ($items as $item) {
            $itemPrice = $item->quantity * $item->unitPrice;

            $total += $itemPrice;
        }

        if ($couponDiscount) {
            $discountValue = $total * $couponDiscount;

            return $total - $discountValue;
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

        $canceled = [
            "status" => "canceled"
        ];

        return $this->repository->deleteOrder($canceled, $id);
    }
}