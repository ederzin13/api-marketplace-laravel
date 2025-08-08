<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\GenericResource;
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
        $addresses = $this->service->getAll();

        return new GenericResource($addresses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $validatedData = $this->service->newAddress($request->validated());

        return response()->json([
            "message" => "Endereço cadastrado",
            "data" => new GenericResource($request)
        ], 201); 
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $address = $this->service->getOne($id);

        return new GenericResource($address);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, $id)
    {
        $validatedData = $request->validated();

        $toUpdate = $this->service->getOne($id);

        $this->service->updateAddress($validatedData, $id);

        return response()->json([
            "original" => $toUpdate,
            "updated" => new GenericResource($request)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deletedAddress = $this->service->getOne($id);

        return response()->json([
            "to_delete" => $deletedAddress,
            "deleted" => $this->service->deleteAddress($id),
        ], 200);
    }
}
