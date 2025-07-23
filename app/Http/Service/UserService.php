<?php

namespace App\Http\Service;

use App\Http\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService {
    public function __construct(protected UserRepository $repository) {}

    public function getAll() {
        return $this->repository->getAll();
    }

    //REGISTRO DE USUÁRIOS
    //não sei se é o correto deixar definir o role logo de cara
    public function newUser(array $data) {
        return $this->repository->newUser([
            "name" => $data["name"],
            "email" => $data["email"],
            "role" => $data["role"] ?? "client",
            "password" => Hash::make($data["password"])
        ]);
    }

    public function createCart() {
        
    }

    public function updateRole($email) {
        $role = ["role" => "moderator"];

        return $this->repository->updateRole($email, $role);
    }

    public function displayOne($id) {
        return $this->repository->displayOne($id);
    }

    public function update(array $data, $id) {
        return $this->repository->updateUser($data, $id);
    }

    public function deleteOne($id) {
        return $this->repository->deleteOne($id);
    }
}