<?php

namespace App\Http\Service;

use App\Http\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService {
    public function __construct(protected UserRepository $repository) {}

    public function getAll() {
        return $this->repository->getAll();
    }

    public function newUser(array $data) {
        return $this->repository->newUser([
            "name" => $data["name"],
            "email" => $data["email"],
            "role" => $data["role"],
            "password" => Hash::make($data["password"])
        ]);
    }

    public function displayOne($id) {
        return $this->repository->displayOne($id);
    }

    public function update(array $data) {
        return $this->repository->updateOne($data);
    }

    public function deleteOne($id) {
        return $this->repository->deleteOne($id);
    }
}