<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Service\AddressService;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(protected AddressService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->service->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $validatedData = $this->service->newAddress($request->validated());

        return response()->json([
            "message" => "Endereço cadastrado",
            "data" => $validatedData
        ], 201); //será que coloco os status em todos os métodos?
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json($this->service->getOne($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, $id)
    {
        $validatedData = $request->validated();

        return response()->json($this->service->updateAddress($validatedData, $id), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return response()->json([
            "to_delete" => $this->show($id),
            "deleted" => $this->service->deleteAddress($id),
            "message" => "success"
        ], 200);
    }
}
