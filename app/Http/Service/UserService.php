<?php

namespace App\Http\Service;

use App\Http\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService {
    public function __construct(protected UserRepository $repository) {}

    public function getAll() {
        return $this->repository->getAll();
    }

    // public function newUser(array $data) {
    //     return $this->repository->newUser([
    //         "name" => $data["name"],
    //         "email" => $data["email"],
    //         "role" => $data["role"],
    //         "password" => Hash::make($data["password"])
    //     ]);
    // }

    public function displayOne($id) {
        return $this->repository->displayOne($id);
    }

    public function update(array $data) {
        return $this->repository->updateOne($data);
    }

    // public function login(array $credentials) {
    //     $user = $this->repository->getByEmail($credentials["email"]);

    //     //há problemas AQUI

    //     if (!$user || !Hash::check($credentials["password"], $user->password)) {
    //         //dd($credentials);

    //         throw ValidationException::withMessages([
    //             "email" => "As credenciais estão incorretas"
    //         ]);

    //         //dd($error);
    //     }
        
    //     return $user->createToken("auth_token")->plainTextToken;
    // }

    // public function logout(Request $request) {
    //     Auth::logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();
    // }

    public function deleteOne($id) {
        return $this->repository->deleteOne($id);
    }
}