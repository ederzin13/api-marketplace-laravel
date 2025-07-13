<?php

namespace App\Http\Service;

use App\Http\Repository\AddressRepository; 

class AddressService {
    public function __construct(protected AddressRepository $repository) {}

    public function getAll() {
        return $this->repository->getAll();
    }

    public function newAddress(array $data) {
        return $this->repository->newAddress($data);
    }

    public function getOne($id) {
        return $this->repository->getOne($id);
    }

    public function updateAddress(array $data, $id) {
        return $this->repository->updateAddress($data, $id);
    }
}