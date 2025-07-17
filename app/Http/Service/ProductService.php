<?php

namespace App\Http\Service;

use App\Http\Repository\ProductRepository;
use Illuminate\Support\Facades\Gate;

class ProductService {
    public function __construct(protected ProductRepository $repository) {}

    public function getAll() {
        return $this->repository->getAll();
    }

    public function getOne($id) {
        return $this->repository->getOne($id);
    }

    public function newProduct(array $data) {
        Gate::authorize("manageProducts");

        return $this->repository->newProduct($data);
    }

    public function updateProduct(array $data, $id) {
        Gate::authorize("manageProducts");

        return $this->repository->updateProduct($data, $id);
    }

    public function deleteProduct($id) {
        Gate::authorize("manageProducts");

        return $this->repository->deleteProduct($id);
    }
}