<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Http\Resources\GenericResource;
use App\Http\Service\CouponService;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function __construct(protected CouponService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = $this->service->getAll();

        return GenericResource::collection($coupons);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request)
    {
        $this->service->createCoupon($request->validated());

        return response()->json([
            "new_coupon" => new GenericResource($request),
            "message" => "success"
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
    public function update(UpdateCouponRequest $request, $id)
    {
        $toUpdate = $this->service->getOne($id);

        $this->service->updateCoupon($request->validated(), $id);

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
        return response()->json([
            "to_delete" => $this->show($id),
            "deleted" => $this->service->deleteCoupon($id),
            "message" => "success"
        ]);
    }
}
