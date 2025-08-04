<?php

namespace App\Http\Service;

use App\Http\Repository\DiscountRepository;

class DiscountService {
    public function __construct(protected DiscountRepository $repository) {}

    public function getAll() {
        return $this->repository->getAll();
    }

    public function getOne($id) {
        return $this->repository->getOne($id);
    }

    public function newDiscount(array $data) {
        return $this->repository->newDiscount($data);
    }

    public function updateDiscount(array $data, $id) {
        return $this->repository->updateDiscount($data, $id);
    }

    public function deleteDiscount($id) {
        return $this->repository->deleteDiscount($id);
    }
}