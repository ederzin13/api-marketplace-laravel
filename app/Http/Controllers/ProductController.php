<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Service\ProductService;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct(protected ProductService $service) {}

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
    public function store(StoreProductRequest $request)
    {
        $validatedData = $this->service->newProduct($request->validated());

        return response()->json([
            "message" => "produto adicionado",
            "product" => $validatedData
        ]);
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
    public function update(UpdateProductRequest $request, $id)
    {
        $validatedData = $this->service->updateProduct($request->validated(), $id);

        return response()->json([
            "message" => "updated",
            "updated_product" => $validatedData
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return response()->json([
            "message" => "deletado",
            "deleted" => $id
        ]);
    }
}
