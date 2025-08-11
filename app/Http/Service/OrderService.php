<?php

namespace App\Http\Service;

use App\Http\Repository\CartRepository;
use App\Http\Repository\CouponRepository;
use App\Http\Repository\OrderItemRepository;
use App\Http\Repository\OrderRepository;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class OrderService {
    public function __construct(
        protected OrderRepository $repository,
        protected OrderItemRepository $orderItemRepository,
        protected ProductService $productService,
        protected CouponRepository $couponRepository,
        protected CartRepository $cartRepository
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

        $cart = $this->cartRepository->getMyCart($user->id);

        if ($cart->cartItems->isEmpty()) {
            throw new HttpResponseException(
                response()->json([
                    "message" => "Carrinho vazio"
                ], 400) 
            );
        }

        $couponDiscount = null;

        //se couponId não estiver vazio e o cupom estiver ativo
        //a expressão retorna true
        if (!empty($data["couponId"]) 
                && 
            !empty($this->couponRepository->getActiveCoupon($data["couponId"]))
            ) 
            {
            $coupon = Coupon::findOrFail($data["couponId"]);

            $couponDiscount = $coupon->discountPercentage / 100;
        }

        //aplica os descontos nos items do pedido, se houver
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

        if (!$this->addressBelongsToUser($data["addressId"], $user->id)) {
            throw new AuthenticationException("Endereço inválido");
        } 

        //finalmente cria o pedido
        $order = $this->repository->newOrder([
            "userId" => $user->id,
            "addressId" => $data["addressId"],
            "orderDate" => now(),
            "couponId" => $data["couponId"] ?? null,
            "status" => "pending",
            "totalAmount" => $this->totalAmount($finalItems, $couponDiscount)
        ]);

        $this->storeOrderItem($finalItems);
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

    public function totalAmount($items, $couponDiscount) {
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
            throw new AuthenticationException("Pedido não pertence a esse usuário");
        }
    }

    public function addressBelongsToUser($addressId, $userId): bool {
        return Address::where("userId", "=", $userId)
            ->where("id", "=", $addressId)
            ->exists();
    }

    public function cancelOrder($id) {
        $this->orderBelongsToUser($id);

        $canceled = [
            "status" => "canceled"
        ];

        return $this->repository->deleteOrder($canceled, $id);
    }
}