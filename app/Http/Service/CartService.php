<?php

namespace App\Http\Service;

use App\Http\Repository\CartRepository;
use Illuminate\Support\Facades\Auth;


class CartService {
    public function __construct(protected CartRepository $repository) {}

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
}