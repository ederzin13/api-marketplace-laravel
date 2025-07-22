<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
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
        return response()->json($this->service->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscountRequest $request)
    {
        $validatedData = $this->service->newDiscount($request->validated());

        return response()->json([
            "new_discount" => $validatedData
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json($this->service->getOne($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscountRequest $request, $id)
    {
        $toUpdate = $this->show($id);

        $validatedData = $this->service->updateDiscount($request->validated(), $id);

        return response()->json([
            "original" => $toUpdate,
            "updated" => $request->all()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $toDelete = $this->show($id);

        return response()->json([
            "to_delete" => $toDelete,
            "deleted" => $this->service->deleteDiscount($id)
        ]);
    }
}
