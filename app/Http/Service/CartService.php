<?php

namespace App\Http\Service;

use App\Http\Repository\CartRepository;

class CartService {
    public function __construct(protected CartRepository $repository) {}

    public function getAll() {
        return $this->repository->getAll();
    }

    public function getOne($id) {
        
    }

    public function createCart($id) {
        return $this->repository->createCart($id);
    }
}