<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Service\UserService;

class AuthController extends Controller
{
    public function __construct(protected UserService $service) {}

    public function register(RegisterUserRequest $request)
    {
        $user = $this->service->newUser($request->validated());
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
            "message" => "Login deu certo",
            "token" => $token
        ]);
    }
}
