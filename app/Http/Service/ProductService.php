<?php

namespace App\Http\Service;

use App\Http\Repository\DiscountRepository;
use App\Http\Repository\ProductRepository;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;

class ProductService {
    public function __construct(
        protected ProductRepository $repository,
        protected DiscountRepository $discountRepository
        ) {}

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

    public function applyDiscount($productId) {
        $product = $this->getOne($productId);

        $total = $product->price;

        $activeDiscount = $this->discountRepository->getActiveDiscount($productId)->first();

        if ($activeDiscount) {
            $discountValue = $product->price * ($activeDiscount->discountPercentage / 100);

            return $total -= $discountValue;  
        }
    }

    public function hasDiscount($productId) {
        $activeDiscounts = $this->discountRepository->getActiveDiscount($productId);

        if (!$activeDiscounts->isEmpty()) {
            return true;
        }

        return false;
    }
}