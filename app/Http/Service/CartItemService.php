<?php

namespace App\Http\Service;

use App\Http\Repository\CartItemRepository;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartItemService {
    public function __construct(protected CartItemRepository $repository) {}

    public function getItems() {
        $user = Auth::user();

        return $this->repository->getItems($user->cart->id);
    }

    public function getOneItem($id) {
        return $this->repository->getOneItem($id);
    }

    public function addItem(array $data) {
        $product = Product::find($data["productId"]);

        $item = $this->repository->addItem([
            "cartId" => $data["cartId"],
            "productId" => $data["productId"],
            "quantity" => $data["quantity"],
            "unitPrice" => $product->price
        ]);

        return $item;
    }

    public function updateItem($data, $id) {
        $product = Product::find($data["productId"]);

        return $this->repository->updateItem([
            "productId" => $data["productId"],
            "quantity" => $data["quantity"],
            "unitPrice" => $product->price
        ], $id);
    }

    public function removeItem($id) {
        return $this->repository->removeItem($id);
    }
}