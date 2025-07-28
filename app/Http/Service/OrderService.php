<?php

namespace App\Http\Service;

use App\Http\Repository\OrderRepository;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class OrderService {
    public function __construct(protected OrderRepository $repository) {}

    public function newOrder(array $data) {
        $user = Auth::user();

        $items = CartItem::where("cartId", "=", $user->id)->get();

        dd($items);
        // return $this->repository->newOrder($data);
    }
}