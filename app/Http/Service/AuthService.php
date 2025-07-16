<?php

namespace App\Http\Service;

use App\Http\Repository\UserRepository;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException; 

class AuthService {
    public function __construct(protected UserRepository $repository) {}

    public function newUser(array $data) {
        return $this->repository->newUser([
            "name" => $data["name"],
            "email" => $data["email"],
            "role" => $data["role"],
            "password" => Hash::make($data["password"])
        ]);
    }

    public function authenticate(LoginRequest $request) {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // return redirect()->intended("/");
            return [
                "message" => "autenticado"
            ];
        } else {
            return [
                "message" => "erro por algum motivo"
            ];
        }
    }

    public function login(array $credentials) { //talvez usar uma request aqui
        $user = $this->repository->getByEmail($credentials["email"]);

        //há problemas AQUI!   --simm

        if (!$user || !Hash::check($credentials["password"], $user->password)) {
            return $error = ValidationException::withMessages([
                "email" => "As credenciais estão incorretas"
            ])->status(422);
        }

        $user->tokens()->delete();
        
        return $user->createToken("auth_token")->plainTextToken;
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}