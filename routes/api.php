<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckIfIsAdmin;
use App\Http\Middleware\CheckIfIsModerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//cadastrar novo usuário
Route::post("/register", [AuthController::class, "register"]);
//logar
Route::post("/login", [AuthController::class, "login"]);//->name("login");

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(["auth:sanctum"])->group(function () {
    Route::apiResource("/users", UserController::class);
    
    Route::apiResource("/addresses", AddressController::class);
    Route::post("/addresses/{id}", [AddressController::class, "update"]);
    
    //deslogar
    Route::post("/logout", [AuthController::class, "logout"]);
    //crud categorias
    Route::apiResource("/categories", CategoryController::class)->middleware(CheckIfIsAdmin::class);

    //crud produtos
    Route::apiResource("/products", ProductController::class)->middleware(CheckIfIsModerator::class);
    Route::post("/products/{id}", [ProductController::class, "update"])->middleware(CheckIfIsModerator::class);
});


Route::apiResource("/discounts", DiscountController::class);