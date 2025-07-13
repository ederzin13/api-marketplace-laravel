<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("/users", UserController::class)->middleware("auth:sanctum");

Route::apiResource("/addresses", AddressController::class);

Route::post("/addresses/{id}", [AddressController::class, "update"]);