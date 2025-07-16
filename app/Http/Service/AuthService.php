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

    public function authenticate(LoginRequest $request) {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return [
                "message" => "autenticado"
            ];
        } else {
            return [
                "message" => "erro por algum motivo"
            ];
        }
    }

    public function login(array $credentials) { 
        $user = $this->repository->getByEmail($credentials["email"]);

        if (!$user || !Hash::check($credentials["password"], $user->password)) {
            return ValidationException::withMessages([
                "email" => "As credenciais estão incorretas"
            ])->status(422);
        }

        $user->tokens()->delete();
        
        return $user->createToken("auth_token")->plainTextToken;
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
    }
}