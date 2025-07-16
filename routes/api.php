<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//logar
Route::post("/login", [AuthController::class, "login"])->name("login");

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(["auth:sanctum"])->group(function () {
    Route::apiResource("/users", UserController::class);
    
    Route::apiResource("/addresses", AddressController::class);
    
    //crud categorias
    Route::apiResource("/categories", CategoryController::class);
    
    Route::post("/addresses/{id}", [AddressController::class, "update"]);
});


//cadastrar novo usuário
Route::post("/register", [AuthController::class, "register"]);

//deslogar
Route::post("/logout", [AuthController::class, "logout"]);
