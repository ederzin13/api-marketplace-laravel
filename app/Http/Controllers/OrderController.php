<?php

namespace App\Http\Controllers;

use App\Http\Service\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;

//PRECISO DESSE CONTROLADOR???

class OrderController extends Controller
{
    public function __construct(protected OrderService $service) {}

    /**
     * Display a listing of the resource.
     */

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
        //
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
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return response()->json($this->service->cancelOrder($id));
    }
}
