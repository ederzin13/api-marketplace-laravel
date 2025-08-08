<?php

namespace App\Http\Service;

use App\Http\Service\CartService;
use App\Http\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService {
    public function __construct(protected UserRepository $repository, protected CartService $cartService) {}

    public function getAll() {
        return $this->repository->getAll();
    }

    //REGISTRO DE USUÁRIOS
    public function newUser(array $data) {
        $user = $this->repository->newUser([
            "name" => $data["name"],
            "email" => $data["email"],
            "email_verified_at" => now(),
            "role" => $data["role"] ?? "client",
            "password" => Hash::make($data["password"])
        ]);

        $this->cartService->createCart($user->id);

        return $user;
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