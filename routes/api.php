<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
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
Route::post("/login", [AuthController::class, "login"]);

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
    //arrumar a verificação de email no FUTURO
    Route::apiResource("/users", UserController::class);
    
    //carrinhos
    Route::apiResource("/carts", CartController::class);

    //retorna o carrinho do usuário LOGADO
    Route::get("/cart", [CartController::class, "getMyCart"]);
    //demais rotas envolvendo carrinhos e itens
    Route::get("/cart/items", [CartItemController::class, "index"]);
    Route::post("/cart/items", [CartItemController::class, "store"]);
    Route::put("/cart/items/{id}", [CartItemController::class, "update"]);
    Route::delete("/cart/items/{id}", [CartItemController::class, "destroy"]);

    Route::apiResource("/addresses", AddressController::class);
    Route::post("/addresses/{id}", [AddressController::class, "update"]);
    
    //pedidos
    Route::post("/testarbobers", [CartController::class, "newOrder"]);

    //deslogar
    Route::post("/logout", [AuthController::class, "logout"]);
    
    Route::middleware(CheckIfIsAdmin::class)->group(function () {
        //admin logado envia o e-mail do usuário ALVO como requisição
        Route::post("/users/create-moderator", [UserController::class, "createModerator"]);
        
        //crud categorias
        Route::post("/categories", [CategoryController::class, "store"]);
        Route::put("/categories/{id}", [CategoryController::class, "update"]);
        Route::delete("/categories/{id}", [CategoryController::class, "destroy"]);

        //crud cupons
        Route::get("/coupons", [CouponController::class, "index"]);
        Route::get("/coupons/{id}", [CouponController::class, "show"]);
        Route::post("/coupons", [CouponController::class, "store"]);
        Route::put("/coupons/{id}", [CouponController::class, "update"]);
        Route::delete("/coupons/{id}", [CouponController::class, "destroy"]);

        //crud descontos
        Route::apiResource("/discounts", DiscountController::class);
    }); 

    Route::middleware(CheckIfIsModerator::class)->group(function () {
        //crud produtos
        Route::post("/products", [ProductController::class, "store"]);
        Route::put("/products/{id}", [ProductController::class, "update"])->middleware(CheckIfIsModerator::class); //isso daqui faz sentido? Digo... todas essas rotas já estão dentro do middleware de moderador >.<
        Route::put("/products/{id}/stock", [ProductController::class, "updateStock"])->middleware(CheckIfIsModerator::class);
        Route::delete("/products/{id}", [ProductController::class, "destroy"])->middleware(CheckIfIsModerator::class);
        //falta a rota de atualizar imagem >-<, obter produtos por categoria e obter produtos de usuário vamos VER
    });
});

