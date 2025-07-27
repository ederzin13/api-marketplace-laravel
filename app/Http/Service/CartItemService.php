<?php

namespace App\Http\Service;

use App\Http\Repository\CartItemRepository;
use Illuminate\Support\Facades\Auth;

class CartItemService {
    public function __construct(protected CartItemRepository $repository) {}

    public function getItems() {
        $user = Auth::user();

        return $this->repository->getItems($user->carts->id);
    }

    public function addItem(array $data) {
        return $this->repository->addItem($data);
    }
}