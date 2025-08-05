<?php

namespace App\Http\Controllers;

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
        return response()->json($this->service->getAll());
    }

    //retorna só as rotas do usuário
    public function index()
    {
        return response()->json($this->service->getMyOrders());
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
        return $this->service->getOne($id);
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
            return response()->json($this->service->cancelOrder($id));
        }

        catch (AuthorizationException $error) {
            return response()->json([
                "message" => $error
            ]);
        }
    }
}
