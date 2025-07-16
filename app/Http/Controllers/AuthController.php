<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Service\AuthService;
// use App\Http\Service\UserService;
use App\Http\Service\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $service, protected UserService $userService) {}

    public function register(RegisterUserRequest $request)
    {
        $user = $this->userService->newUser($request->validated());
        //dd($user);
        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "message" => "deu certo",
            "token" => $token,
            "data" => $user
        ], 201);
    }

    public function login(LoginRequest $request) {
        $token = $this->service->login($request->validated());

        return response()->json([
            "token" => $token
        ]);
    }

    public function logout(Request $request) {
        $this->service->logout($request);

        return response()->json([
            "message" => "Deslogado"
        ]);
    }
}
