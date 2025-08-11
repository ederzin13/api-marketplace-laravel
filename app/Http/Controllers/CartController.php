<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\GenericResource;
use App\Http\Service\CartItemService;
use App\Http\Service\CartService;
use App\Http\Service\OrderService;
use Illuminate\Auth\Access\AuthorizationException;

class CartController extends Controller
{
    public function __construct(
        protected CartService $service, 
        protected OrderService $orderService,
        protected CartItemService $cartItemService
        ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = $this->service->getAll();

        return GenericResource::collection($carts);
    }

    public function getMyCart() {
        $myCart = $this->service->getMyCart();

        return new GenericResource($myCart);
    }

    public function newOrder(StoreOrderRequest $request) {
        try {
            $this->orderService->newOrder($request->validated());  

            $items = $this->cartItemService->getItems();

            return response()->json([
                "data" => $request->all(),
                "items" => $items,
                "message" => "created"
            ], 201);
        }

        catch (AuthorizationException $error) {
            return response()->json([
                "message" => $error->getMessage()
            ]);
        }
    }
}
