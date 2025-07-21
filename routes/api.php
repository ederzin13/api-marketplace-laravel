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

//Mostrar produtos --> não precisa de autenticação
Route::get("/products", [ProductController::class, "index"]);
Route::get("/products/{id}", [ProductController::class, "show"]);

//Mostrar categorias --> também não precisa de autenticação
Route::get("/categories", [CategoryController::class, "index"]);
Route::get("/categories/{id}", [CategoryController::class, "show"]);

Route::middleware(["auth:sanctum"])->group(function () {
    Route::apiResource("/users", UserController::class);
    
    Route::apiResource("/addresses", AddressController::class);
    Route::post("/addresses/{id}", [AddressController::class, "update"]);
    
    //deslogar
    Route::post("/logout", [AuthController::class, "logout"]);

    //crud categorias
    // Route::apiResource("/categories", CategoryController::class)->middleware(CheckIfIsAdmin::class);


    //crud produtos
    // Route::apiResource("/products", ProductController::class)->middleware(CheckIfIsModerator::class);
    Route::post("/products", [ProductController::class, "store"]);
    Route::put("/products/{id}", [ProductController::class, "update"])->middleware(CheckIfIsModerator::class);
    Route::put("/products/{id}/stock", [ProductController::class, "updateStock"])->middleware(CheckIfIsModerator::class);
    Route::delete("/products/{id}", [ProductController::class, "destroy"])->middleware(CheckIfIsModerator::class);
    //falta a rota de atualizar imagem >-<, obter produtos por categoria e obter produtos de usuário vamos VER
});


Route::apiResource("/discounts", DiscountController::class);