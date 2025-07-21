<?php

namespace App\Http\Service;

use App\Http\Repository\CouponRepository; 

class CouponService {
    public function __construct(protected CouponRepository $repository) {}

    public function getAll() {
        return $this->repository->getAll();
    }

    public function getOne($id) {
        return $this->repository->getOne($id);
    }

    public function createCoupon(array $data) {
        return $this->repository->createCoupon($data);
    }

    public function updateCoupon(array $data, $id) {
        return $this->repository->updateCoupon($data, $id);
    }

    public function deleteCoupon($id) {
        return $this->repository->deleteCoupon($id);
    }
}