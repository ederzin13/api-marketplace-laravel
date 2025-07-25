<?php

namespace App\Http\Service;

use App\Http\Repository\CartItemRepository;

class CartItemService {
    public function __construct(protected CartItemRepository $repository) {}

    public function getAll($id) {
        return $this->repository->getAll($id);
    }

    public function addItem(array $data) {
        return $this->repository->addItem($data);
    }
}