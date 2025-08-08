<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Service\OrderService;
use App\Models\Order;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

//PRECISO DESSE CONTROLADOR???

class OrderController extends Controller
{
    public function __construct(protected OrderService $service) {}

    /**
     * Display a listing of the resource.
     */

    public function getAll() {
        $orders = $this->service->getAll();

        return OrderResource::collection($orders);
    }

    //retorna só as rotas do usuário
    public function index()
    {
        $myOrders = $this->service->getMyOrders();

        return OrderResource::collection($myOrders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //ESSE MÉTODO FICA EM OUTRO LUGAR -> CART CONTROLLER
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = $this->service->getOne($id);

        $order->load("orderItems");

        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->only("status");

        $toUpdate = $this->show($id);

        return response()->json([
            "to_update" => $toUpdate,
            "updated" => $this->service->updateStatus($validatedData, $id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $deletedOrder = $this->show($id);

            $this->service->cancelOrder($id);

            return response()->json([
                "message" => "deleted",
                "deleted_order" => $deletedOrder
            ]);
        }

        catch (AuthorizationException $error) {
            return response()->json([
                "message" => $error
            ]);
        }
    }
}
