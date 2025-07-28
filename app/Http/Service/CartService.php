<?php

namespace App\Http\Service;

use App\Http\Repository\CartRepository;
use App\Http\Repository\OrderRepository;
use Illuminate\Support\Facades\Auth;


class CartService {
    public function __construct(
        protected CartRepository $repository,
        protected OrderRepository $orderRepository
        ) {}

    public function getAll() {
        return $this->repository->getAll();
    }

    public function getMyCart() {
        $user = Auth::user();

        return $this->repository->getMyCart($user->id);
    }

    public function createCart($id) {
        return $this->repository->createCart($id);
    }

    public function newOrder() {
        $user = Auth::user();

        $cart = $this->repository->getMyCart($user->id);

        if ($cart->cartItems->isEmpty()) {
            return [
                "message" => "nada no carrinho"
            ];
        }

        
    }
}