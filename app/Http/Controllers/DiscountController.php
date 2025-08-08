<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Http\Resources\DiscountResource;
use App\Http\Resources\GenericResource;
use App\Http\Service\DiscountService;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function __construct(protected DiscountService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = $this->service->getAll();

        $discounts->load("product");

        return DiscountResource::collection($discounts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscountRequest $request)
    {
        $this->service->newDiscount($request->validated());

        return response()->json([
            "new_discount" => new GenericResource($request)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $discount = $this->service->getOne($id);

        $discount->load("product");

        return new DiscountResource($discount);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscountRequest $request, $id)
    {
        $toUpdate = $this->service->getOne($id);

        $this->service->updateDiscount($request->validated(), $id);

        $updated = $this->service->getOne($id);

        return response()->json([
            "original" => $toUpdate,
            "updated" => $updated
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $toDelete = $this->service->getOne($id);

        return response()->json([
            "to_delete" => $toDelete,
            "deleted" => $this->service->deleteDiscount($id)
        ]);
    }
}
